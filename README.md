# Enums

[![Author][ico-author]][link-author]
[![PHP Version][ico-php]][link-php]
[![Latest Version][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-actions]][link-actions]
[![Code Quality][ico-code-quality]][link-code-quality]
[![Coverage][ico-coverage]][link-coverage]
[![PHPStan Level][ico-phpstan]][link-phpstan]
[![Total Downloads][ico-downloads]][link-downloads]

A collection of enum helpers for PHP.

> [!TIP]
> Need to supercharge enums in a Symfony application?
>
> Consider using [Enums Bundle](https://github.com/parler-haut-interagir-librement/enums-bundle) instead.

A collection of enum helpers for PHP.

- [`AsInvocableEnum`](#asinvocableenum)
- [`AsNameableEnum`](#asnameableenum)
- [`AsValuableEnum`](#asvaluableenum)
- [`AsSelectableEnum`](#asselectableenum)
- [`AsComparableEnum`](#AsComparableEnum)
- [`AsFromambleEnum`](#AsFromambleEnum)
- [`AsMetadableEnum`](#AsMetadableEnum)
- [`AsStringSelectableEnum`](#asstringselectableenum)

## Table of Contents
- [Installation](#installation)
- [Usage](#usage) 
  - [`AsInvocableEnum`](#asinvocableenum)
    - [Apply the trait on your enum](#apply-the-trait-on-your-enum)
    - [Use static calls to get the primitive value](#use-static-calls-to-get-the-primitive-value)
    - [Invoke instances to get the primitive value](#invoke-instances-to-get-the-primitive-value)
  - [`AsNameableEnum`](#asnameableenum)
      - [Apply the trait on your enum](#apply-the-trait-on-your-enum-1)
      - [`names()`](#use-the-names-method)
  - [`AsValuableEnum`](#asvaluableenum)
      - [Apply the trait on your enum](#apply-the-trait-on-your-enum-2)
      - [`values()`](#use-the-values-method)
  - [`AsSelectableEnum`](#asselectableenum)
      - [Apply the trait on your enum](#apply-the-trait-on-your-enum-3)
      - [`options()`](#use-the-options-method)
  - [`AsComparableEnum`](#AsComparableEnum)
      - [Apply the trait on your enum](#apply-the-trait-on-your-enum-4)
      - [`is()`](#use-the-is-method)
      - [`isNot()`](#use-the-isnot-method)
      - [`in()`](#use-the-in-method)
      - [`notIn()`](#use-the-notin-method)
  - [`AsFromambleEnum`](#AsFromambleEnum)
      - [Important Notes](#important-notes)
      - [Apply the trait on your enum](#apply-the-trait-on-your-enum-5)
      - [`from()`](#use-the-from-method)
      - [`tryFrom()`](#use-the-tryfrom-method)
      - [`fromName()`](#use-the-fromname-method)
      - [`tryFromName()`](#use-the-tryfromname-method)
  - [`AsMetadableEnum`](#AsMetadableEnum)
    - [Apply the trait on your enum](#apply-the-trait-on-your-enum-6)
    - [Access the Metadata](#access-the-metadata)
    - [Creating Meta Properties](#creating-meta-properties)
    - [`fromMeta()`](#use-the-frommeta-method)
    - [`tryFromMeta()`](#use-the-tryfrommeta-method)
    - [Included Meta Properties](#included-meta-properties)
      - [Description](#description)
      - [Group](#group)
      - [Label](#label)
    - [Recommandations](#recommendation-use-annotations-and-traits)
  - [`AsStringSelectableEnum`](#asstringselectableenum)
    - [Apply the trait on your enum](#apply-the-trait-on-your-enum-7)
    - [`stringOptions()`](#use-the-stringoptions-method)
- [PHPStan](#phpstan)
- [Development](#development)
- [Todo](#todo)

## Installation

PHP 8.1+ is required.

Via Composer : 
```sh
composer require ph-il/enums
```

## Usage

To supercharge our enums with all the features (except [AsStringSelectableEnum](#asstringselectableenum)) provided by this package, we can let our enums use the Enumerates trait:

```php
use Phil\Enums\Traits\AsEnumerableEnumTrait;

enum PureEnum
{
    use AsEnumerableEnumTrait;

    case ONE;
    case TWO;
    case THREE;
}

enum BackedEnum: int
{
    use AsEnumerableEnumTrait;

    case ONE = 1;
    case TWO = 2;
    case THREE = 3;
}
```

### AsInvocableEnum

This helper lets you get the value of a backed enum, or the name of a pure enum, by "invoking" it — either statically (`BackedEnum::THREE()` instead of `BackedEnum::THREE->value`), or as an instance (`$enum()`).

That way, you can use enums as array keys:
```php
'statuses' => [
    TaskStatus::INCOMPLETE() => ['some configuration'],
    TaskStatus::COMPLETED() => ['some configuration'],
],
```

Or access the underlying primitives for any other use cases:
```php
public function updateStatus(int $status): void;

$task->updateStatus(TaskStatus::COMPLETED());
```

The main point: this is all without having to append `->value` to everything.

This approach also has *decent* IDE support. You get autosuggestions while typing, and then you just append `()`:

```php
BackedEnum::THREE; // => BackedEnum instance
BackedEnum::THREE(); // => 3
```

#### Apply the trait on your enum

```php
use Phil\Enums\Traits\AsInvocableEnumTrait;

enum TaskStatus: int
{
    use AsInvocableEnumTrait;

    case INCOMPLETE = 0;
    case COMPLETED = 1;
    case CANCELED = 2;
}
enum Role
{
    use AsInvocableEnumTrait;

    case ADMINISTRATOR;
    case SUBSCRIBER;
    case GUEST;
}

enum PureEnum
{
    use AsInvocableEnumTrait;

    case ONE;
    case TWO;
    case THREE;
}

enum BackedEnum: int
{
    use AsInvocableEnumTrait;

    case ONE = 1;
    case TWO = 2;
    case THREE = 3;
}
```

#### Use static calls to get the primitive value
```php
BackedEnum::ONE(); // 1
BackedEnum::TWO(); // 2
BackedEnum::THREE(); // 3
PureEnum::ONE(); // 'ONE'
PureEnum::TWO(); // 'TWO'
PureEnum::THREE(); // 'THREE'
```

#### Invoke instances to get the primitive value
```php
public function updateStatus(TaskStatus $status, Role $role)
{
    $this->record->setStatus($status(), $role());
}
```


### AsNameableEnum

This helper returns a list of case *names* in the enum.

#### Apply the trait on your enum

```php
use Phil\Enums\Traits\AsNameableEnumTrait;

enum TaskStatus: int
{
    use AsNameableEnumTrait;

    case INCOMPLETE = 0;
    case COMPLETED = 1;
    case CANCELED = 2;
}

enum Role
{
    use AsNameableEnumTrait;

    case ADMINISTRATOR;
    case SUBSCRIBER;
    case GUEST;
}
```

#### Use the `names()` method
```php
TaskStatus::names(); // ['INCOMPLETE', 'COMPLETED', 'CANCELED']
Role::names(); // ['ADMINISTRATOR', 'SUBSCRIBER', 'GUEST']
```

### AsValuableEnum

This helper returns a list of case *values* for backed enums, or a list of case *names* for pure enums (making this functionally equivalent to [`::names()`](#names) for pure Enums)

#### Apply the trait on your enum

```php
use Phil\Enums\Traits\AsValuableEnumTrait;

enum TaskStatus: int
{
    use AsValuableEnumTrait;

    case INCOMPLETE = 0;
    case COMPLETED = 1;
    case CANCELED = 2;
}

enum Role
{
    use AsValuableEnumTrait;

    case ADMINISTRATOR;
    case SUBSCRIBER;
    case GUEST;
}
```

#### Use the `values()` method
```php
TaskStatus::values(); // [0, 1, 2]
Role::values(); // ['ADMINISTRATOR', 'SUBSCRIBER', 'GUEST']
```

### AsSelectableEnum

This helper returns an associative array of case names and values for backed enums, or a list of names for pure enums (making this functionally equivalent to [`::names()`](#names) for pure Enums).

#### Apply the trait on your enum

```php
use Phil\Enums\Traits\AsSelectableEnumTrait;

enum TaskStatus: int
{
    use AsSelectableEnumTrait;

    case INCOMPLETE = 0;
    case COMPLETED = 1;
    case CANCELED = 2;
}

enum Role
{
    use AsSelectableEnumTrait;

    case ADMINISTRATOR;
    case SUBSCRIBER;
    case GUEST;
}
```

#### Use the `options()` method
```php
TaskStatus::options(); // ['INCOMPLETE' => 0, 'COMPLETED' => 1, 'CANCELED' => 2]
Role::options(); // ['ADMINISTRATOR', 'SUBSCRIBER', 'GUEST']
```


### AsComparableEnum

This trait lets you compare enums using `is()`, `isNot()`, `in()` and `notIn()`.

#### Apply the trait on your enum

```php
use Phil\Enums\Traits\AsComparableEnumTrait;

enum TaskStatus: int
{
    use AsComparableEnumTrait;

    case INCOMPLETE = 0;
    case COMPLETED = 1;
    case CANCELED = 2;
}

enum Role
{
    use AsComparableEnumTrait;

    case ADMINISTRATOR;
    case SUBSCRIBER;
    case GUEST;
}
```

#### Use the `is()` method
```php
TaskStatus::INCOMPLETE->is(TaskStatus::INCOMPLETE); // true
TaskStatus::INCOMPLETE->is(TaskStatus::COMPLETED); // false
Role::ADMINISTRATOR->is(Role::ADMINISTRATOR); // true
Role::ADMINISTRATOR->is(Role::NOBODY); // false
```

#### Use the `isNot()` method
```php
TaskStatus::INCOMPLETE->isNot(TaskStatus::INCOMPLETE); // false
TaskStatus::INCOMPLETE->isNot(TaskStatus::COMPLETED); // true
Role::ADMINISTRATOR->isNot(Role::ADMINISTRATOR); // false
Role::ADMINISTRATOR->isNot(Role::NOBODY); // true
```

#### Use the `in()` method
```php
TaskStatus::INCOMPLETE->in([TaskStatus::INCOMPLETE, TaskStatus::COMPLETED]); // true
TaskStatus::INCOMPLETE->in([TaskStatus::COMPLETED, TaskStatus::CANCELED]); // false
Role::ADMINISTRATOR->in([Role::ADMINISTRATOR, Role::GUEST]); // true
Role::ADMINISTRATOR->in([Role::SUBSCRIBER, Role::GUEST]); // false
```

#### Use the `notIn()` method
```php
TaskStatus::INCOMPLETE->notIn([TaskStatus::INCOMPLETE, TaskStatus::COMPLETED]); // false
TaskStatus::INCOMPLETE->notIn([TaskStatus::COMPLETED, TaskStatus::CANCELED]); // true
Role::ADMINISTRATOR->notIn([Role::ADMINISTRATOR, Role::GUEST]); // false
Role::ADMINISTRATOR->notIn([Role::SUBSCRIBER, Role::GUEST]); // true
```


### AsFromambleEnum

This helper adds `from()` and `tryFrom()` to pure enums, and adds `fromName()` and `tryFromName()` to all enums.

#### Important Notes:
* `BackedEnum` instances already implement their own `from()` and `tryFrom()` methods, which will not be overridden by this trait. Attempting to override those methods in a `BackedEnum` causes a fatal error.
* Pure enums only have named cases and not values, so the `from()` and `tryFrom()` methods are functionally equivalent to `fromName()` and `tryFromName()`

#### Apply the trait on your enum
```php
use Phil\Enums\AsFromambleEnum;

enum TaskStatus: int
{
    use AsFromambleEnum;

    case INCOMPLETE = 0;
    case COMPLETED = 1;
    case CANCELED = 2;
}

enum Role
{
    use AsFromambleEnum;

    case ADMINISTRATOR;
    case SUBSCRIBER;
    case GUEST;
}
```

#### Use the `from()` method
```php
Role::from('ADMINISTRATOR'); // Role::ADMINISTRATOR
Role::from('NOBODY'); // Error: ValueError
```

#### Use the `tryFrom()` method
```php
Role::tryFrom('GUEST'); // Role::GUEST
Role::tryFrom('NEVER'); // null
```

#### Use the `fromName()` method
```php
TaskStatus::fromName('INCOMPLETE'); // TaskStatus::INCOMPLETE
TaskStatus::fromName('MISSING'); // Error: ValueError
Role::fromName('SUBSCRIBER'); // Role::SUBSCRIBER
Role::fromName('HACKER'); // Error: ValueError
```

#### Use the `tryFromName()` method
```php
TaskStatus::tryFromName('COMPLETED'); // TaskStatus::COMPLETED
TaskStatus::tryFromName('NOTHING'); // null
Role::tryFromName('GUEST'); // Role::GUEST
Role::tryFromName('TESTER'); // null
```

### AsMetadableEnum

This trait lets you add metadata to enum cases.

#### Apply the trait on your enum
```php
use App\Enums\MetaProperties\Color;
use Phil\Enums\AsMetadableEnum;
use Phil\Enums\Attribute\Description;
use Phil\Enums\Attribute\Meta;

#[Meta(Description::class, Color::class)]
enum TaskStatus: int
{
    use AsMetadableEnum;

    #[Description('Incomplete Task')] #[Color('red')]
    case INCOMPLETE = 0;

    #[Description('Completed Task')] #[Color('green')]
    case COMPLETED = 1;

    #[Description('Canceled Task')] #[Color('gray')]
    case CANCELED = 2;
}
```

Explanation:
- `Description` is an exemple that we do provide as a class attributes for meta properties
- `Color` is userland class attributes — meta properties
- The `#[Meta]` call enables those two meta properties on the enum
- Each case must have a defined description & color (in this example)

#### Access the metadata

```php
TaskStatus::INCOMPLETE->description(); // 'Incomplete Task'
TaskStatus::COMPLETED->color(); // 'green'
```

#### Creating meta properties

Each meta property (= attribute used on a case) needs to exist as a class.
```php
#[Attribute]
class Color extends MetaProperty {}

#[Attribute]
class Description extends MetaProperty {}
```

Inside the class, you can customize a few things. For instance, you may want to use a different method name than the one derived from the class name (`Description` becomes `description()` by default). To do that, override the `method()` method on the meta property:
```php
#[Attribute]
class Description extends MetaProperty
{
    public static function method(): string
    {
        return 'note';
    }
}
```

With the code above, the description of a case will be accessible as `TaskStatus::INCOMPLETE->note()`.

Another thing you can customize is the passed value. For instance, to wrap a color name like `text-{$color}-500`, you'd add the following `transform()` method:

```php
#[Attribute]
class Color extends MetaProperty
{
    protected function transform(mixed $value): mixed
    {
        return "text-{$value}-500";
    }
}
```

And now the returned color will be correctly transformed:
```php
TaskStatus::COMPLETED->color(); // 'text-green-500'
```

You can also add a `defaultValue()` method to specify the value a case should have if it doesn't use the meta property. That way you can apply the attribute only on some cases and still get a configurable default value on all other cases.

#### Use the `fromMeta()` method
```php
TaskStatus::fromMeta(Color::make('green')); // TaskStatus::COMPLETED
TaskStatus::fromMeta(Color::make('blue')); // Error: ValueError
```

#### Use the `tryFromMeta()` method
```php
TaskStatus::tryFromMeta(Color::make('green')); // TaskStatus::COMPLETED
TaskStatus::tryFromMeta(Color::make('blue')); // null
```

#### Included Meta Properties

##### Description

##### Group

##### Label

#### Recommendation: use annotations and traits

If you'd like to add better IDE support for the metadata getter methods, you can use `@method` annotations:

```php
/**
 * @method string description()
 * @method string color()
 */
#[Meta(Description::class, Color::class)]
enum TaskStatus: int
{
    use Metadata;

    #[Description('Incomplete Task')] #[Color('red')]
    case INCOMPLETE = 0;

    #[Description('Completed Task')] #[Color('green')]
    case COMPLETED = 1;

    #[Description('Canceled Task')] #[Color('gray')]
    case CANCELED = 2;
}
```

And if you're using the same meta property in multiple enums, you can create a dedicated trait that includes this `@method` annotation.


### AsStringSelectableEnum

The trait adds the `stringOptions()` method that can be used for generating convenient string representations of your enum options.

#### Apply the trait on your enum
```php
use Phil\Enums\AsStringSelectableEnumTrait;

enum TaskStatus: int
{
    use AsStringSelectableEnumTrait;

    case INCOMPLETE = 0;
    case COMPLETED = 1;
    case CANCELED = 2;
}

enum Role
{
    use AsStringSelectableEnumTrait;

    case ADMINISTRATOR;
    case SUBSCRIBER;
    case GUEST;
}
```

#### Use the `stringOptions()` method

The trait adds the `stringOptions()` method that can be used for generating convenient string representations of your enum options:

```php
// First argument is the callback, second argument is glue
// returns "INCOMPLETE => 0, COMPLETED => 1, CANCELED => 2"
TaskStatus::stringOptions(fn ($name, $value) => "$name => $value", ', ');
```

For pure enums (non-backed), the name is used in place of `$value` (meaning that both `$name` and `$value` are the same).

Both arguments for this method are optional, the glue defaults to `\n` and the callback defaults to generating HTML `<option>` tags:

```php
// <option value="0">Incomplete</option>
// <option value="1">Completed</option>
// <option value="2">Canceled</option>
TaskStatus::stringOptions(); // backed enum

// <option value="ADMINISTRATOR">Administrator</option>
// <option value="Subscriber">Subscriber</option>
// <option value="GUEST">Guest</option>
Role::stringOptions(); // pure enum
```


## PHPStan

To assist PHPStan when using invokable cases, you can include the PHPStan extensions into your own `phpstan.neon` file:

```yaml
includes:
  - ./vendor/ph-il/enums/extension.neon
```

*Note: If you have installed [`phpstan/extension-installer`](https://github.com/phpstan/extension-installer#usage), the extension is automatically included.*

## Development

Run all checks locally:

```sh
./check
```

Code style will be automatically fixed by php-cs-fixer.


## Todo

* Version 0.2.0
  * Tests
  * Add Castor and all lints/scans used by ph-il projects
  * Add self-awareness
      * isPure
      * isBacked
      * isBackedBy
          * Integer
          * String
* Version 0.3.0 
  * Add operations
    * count
    * first
      * with or without filter via callback
    * Add Filtering and Sorting


[ico-author]: https://img.shields.io/badge/author-cerbero90-blue?logo=x&style=for-the-badge&logoSize=auto
[ico-php]: https://img.shields.io/packagist/php-v/ph-il/enums?color=%23777BB4&logo=php&style=for-the-badge&logoSize=auto
[ico-version]: https://img.shields.io/packagist/v/ph-il/enums.svg?label=version&style=for-the-badge&logo=vitess&logoColor=fff&logoSize=auto
[ico-license]: https://img.shields.io/badge/license-MIT-blue.svg?style=for-the-badge&logo=lerna&logoColor=fff&logoSize=auto
[ico-actions]: https://img.shields.io/github/actions/workflow/status/parler-haut-interagir-librement/enums/build.yml?branch=master&style=for-the-badge&logo=github&logoSize=auto
[ico-code-quality]: https://img.shields.io/codacy/grade/42d72af09c554071be8c7cbd65c57e79?style=for-the-badge&logo=codacy&logoSize=auto
[ico-coverage]: https://img.shields.io/codacy/coverage/42d72af09c554071be8c7cbd65c57e79?style=for-the-badge&logo=codacy&logoSize=auto
[ico-phpstan]: https://img.shields.io/badge/phpstan-max-success?style=for-the-badge&logo=data:image/png;base64,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&logoSize=auto
[ico-downloads]: https://img.shields.io/packagist/dt/ph-il/enums.svg?style=for-the-badge&logo=packagist&logoSize=auto

[link-author]: https://github.com/ph-il
[link-php]: https://www.php.net
[link-packagist]: https://packagist.org/packages/ph-il/enums
[link-actions]: https://github.com/parler-haut-interagir-librement/enums/actions?query=workflow%3Abuild
[link-code-quality]: https://app.codacy.com/gh/parler-haut-interagir-librement/enums/dashboard
[link-coverage]: https://app.codacy.com/gh/parler-haut-interagir-librement/enums/dashboard
[link-downloads]: https://packagist.org/packages/ph-il/enums
[link-phpstan]: https://phpstan.org/
[link-contributors]: ../../contributors
