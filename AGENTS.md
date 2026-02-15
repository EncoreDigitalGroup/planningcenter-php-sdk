# Agents

This file provides guidance to Agents when working with code in this repository.

## Project Overview

PHP SDK for the Planning Center API. This is a v3 rewrite currently in development on the `main` branch. For v2 patches, use `releases/v2.x`.

- **Namespace**: `EncoreDigitalGroup\PlanningCenter`
- **PHP Version**: 8.3+
- **Dependencies**: Laravel components (Illuminate), PHPGenesis HTTP client
- **Documentation**: https://docs.encoredigitalgroup.com/packages/planningcenter/

## Development Commands

### Testing

```bash
# Run all tests in parallel
composer test

# Run a specific test file
vendor/bin/pest tests/Unit/People/PersonTests.php

# Run tests with a specific group
vendor/bin/pest --group=people.profile

# Run tests without parallel execution
vendor/bin/pest
```

## Architecture

### Entry Point: Singleton Pattern

The `PlanningCenter` class is the only allowable entry point to the SDK. All other entry points are for internal SDK usage only. `PlanningCenter` is a singleton. Anytime
an auth method is called (`withBasicAuth` or `withToken`) the singleton is destroyed and recreated with completely new state.

```php
PlanningCenter::make()
    ->withBasicAuth($clientId, $clientSecret)  // or ->withToken($token)
    ->people()
    ->person()
    ->withFirstName("John")
    ->save();
```

**Important**: Always call `withBasicAuth()` or `withToken()` before accessing modules. This resets the singleton and sets credentials.

### Module Organization

The SDK is organized into modules representing Planning Center products:

- **PeopleModule** (`/people/v2`) - People management
- **GroupsModule** (`/groups/v2`) - Group management
- **CalendarModule** (`/calendar/v2`) - Calendar/events
- **WebhooksModule** (`/webhooks/v2`) - Webhook subscriptions

Each module acts as a factory for its resources and provides convenient access methods like `all()`.

### Resource Classes

Resources represent API entities (Person, Group, CalendarEvent, etc.) and use **trait-based composition** for functionality:

- **HasClient** - HTTP client configuration, authentication (Basic/Token), API versioning
- **HasAttributes** - Attribute storage using Laravel Collections, hydration from API responses
- **HasApiMethods** - Static `all()` method returning Paginator, builds resources from arrays
- **HasRead** - `get()` method to fetch by ID (requires `withId()` first)
- **HasCreate** - `create()` method for new resources
- **HasUpdate** - `update()` method for existing resources
- **HasDelete** - `delete()` method
- **HasSave** - `save()` method that auto-detects create vs update based on ID presence
- **HasResponse** - Stores the last HTTP response for debugging/metadata access

### Fluent API Pattern

Resources use a fluent setter/getter pattern:

- **Setters**: `withFirstName()`, `withEmail()` - return `self` for chaining
- **Getters**: `firstName()`, `email()` - return the value
- All setters prefixed with `with`, getters have no prefix

### Pagination

List operations return a `Paginator<TResource>` (readonly, generic):

```php
$paginator = PlanningCenter::make()->people()->all();
$paginator->items();        // Collection of Person instances
$paginator->hasMore();      // bool
$paginator->nextUrl();      // ?string
$paginator->totalCount();   // int
$paginator->response();     // Illuminate\Http\Client\Response
```

### Attribute Handling

Resources define these protected methods for custom behavior:

- `dateAttributes()` - List of datetime fields (parsed to CarbonImmutable)
- `dateOnlyAttributes()` - List of date-only fields (Y-m-d format)
- `readOnlyAttributes()` - Fields excluded from create/update requests (default: id, created_at, updated_at)

### API Versioning

API versions are set per module via `PlanningCenterApiVersion` enum constants and sent as `X-PCO-API-Version` header.

## Testing Conventions

- Tests use **Pest PHP** with `describe()` and `test()` syntax
- Test organization: `tests/Unit/{Module}/{Resource}Tests.php`
- Mock data in `tests/Unit/{Module}/{Module}Mocks.php`
- Test constants in `tests/Helpers/TestConstants.php`
- Tests extend `Tests\TestCase` (configured in `tests/Pest.php`)
- Group tests using `->group('module.feature')` for selective runs

## CI/CD Pipeline

Pull requests run (defined in `.github/workflows/_pullRequest.yml`):

1. **GitStatusCheck** - Determines if code changes require checks
2. **CodeStyle** - Runs Duster for PSR-12 compliance
3. **StaticAnalysis** - PHPStan level 8 analysis
4. **Test** - Full Pest test suite

## Key Design Patterns

1. **Singleton with Credentials** - `PlanningCenter::make()` maintains state for credentials
2. **Trait Composition** - Resources compose behavior from granular traits
3. **Fluent Builders** - All setters return `$this` for method chaining
4. **Smart Save** - `save()` auto-detects create vs update based on ID presence
5. **Lazy Loading** - Relationships like `person->emails()` lazy-load on first access
6. **Type Safety** - PHPStan level 8, consistent constructor annotation for static factories

## Common Workflows

### Adding a New Resource

1. Create class in `src/Resources/` extending appropriate traits
2. Define `ENDPOINT` constant (e.g., `/people/v2/resource`)
3. Add fluent setters (`withAttribute()`) and getters (`attribute()`)
4. Override `dateAttributes()`, `dateOnlyAttributes()`, `readOnlyAttributes()` as needed
5. Add factory method to relevant Module class
6. Create tests in `tests/Unit/{Module}/`
7. Create mock data in `tests/Unit/{Module}/{Module}Mocks.php`

### Adding a New Module

1. Create class in `src/Modules/` extending `Module`
2. Set API version in constructor
3. Add resource factory methods
4. Add convenience `all()` method if needed
5. Add module accessor to `PlanningCenter` class
6. Create test directory and mocks

### Working with Relationships

Resources can define relationship methods that lazy-load related resources (see `Person::emails()` for example).