# Enums

[![Author][ico-author]][link-author]
[![PHP Version][ico-php]][link-php]
[![Latest Version][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-actions]][link-actions]
[![Code Quality][ico-code-quality]][link-code-quality]
[![Coverage][ico-coverage]][link-coverage]
[![PHPStan Level][ico-phpstan]][link-phpstan]
[![Total Downloads][ico-downloads]][link-downloads]

A zero-dependencies collection of enum helper traits for PHP.

> [!TIP]
> Need to supercharge enums in a Symfony application?
>
> Consider using [Enums Bundle](https://github.com/parler-haut-interagir-librement/enums-bundle) instead.


## Available Traits

- [`AsInvocableEnum`](#asinvocableenum) — Access enum values via static calls or invocation
- [`AsNameableEnum`](#asnameableenum) — Get a list of case names
- [`AsValuableEnum`](#asvaluableenum) — Get a list of case values
- [`AsSelectableEnum`](#asselectableenum) — Get an associative array of names → values
- [`AsComparableEnum`](#AsComparableEnum) — Compare enum cases fluently
- [`AsFromambleEnum`](#AsFromambleEnum) — Add `from()`/`tryFrom()` to pure enums and `fromName()`/`tryFromName()` to all enums
- [`AsMetadableEnum`](#AsMetadableEnum) — Attach metadata to enum cases via attributes
- [`AsSelfAwareableEnum`](#asselfawareableenum) — Introspect whether an enum is pure, backed, backed by int or string
- [`AsStringSelectableEnum`](#asstringselectableenum) — Generate string representations of enum options


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
      - [`is()` — Check if the case matches a target](#is--check-if-the-case-matches-a-target)
      - [``isNot()` — Check if the case does not match a target`](#isnot--check-if-the-case-does-not-match-a-target)
      - [`in()` — Check if the case is in a list of targets](#in--check-if-the-case-is-in-a-list-of-targets)
      - [`notIn()` — Check if the case is not in a list of targets](#notin--check-if-the-case-is-not-in-a-list-of-targets)
      - [`has()` — Check if the enum includes a given target (static)](#has--check-if-the-enum-includes-a-given-target-static)
      - [`doesntHave()` — Check if the enum does not include a given target (static)](#doesnthave--check-if-the-enum-does-not-include-a-given-target-static)
      - [`equalsOneOf()` — Check if the case matches any case in an array](#equalsoneof--check-if-the-case-matches-any-case-in-an-array)
      - [`notEqualsOneOf()` — Check if the case does not match any case in an array](#notequalsoneof--check-if-the-case-does-not-match-any-case-in-an-array)
  - [`AsFromambleEnum`](#AsFromambleEnum)
      - [Important Notes](#important-notes)
      - [Apply the trait on your enum](#apply-the-trait-on-your-enum-5)
      - [`from()` — Get a pure enum case by name or throw](#from--get-a-pure-enum-case-by-name-or-throw)
      - [`tryFrom()` — Get a pure enum case by name or null](#tryfrom--get-a-pure-enum-case-by-name-or-null)
      - [`fromName()` — Get any enum case by name or throw](#fromname--get-any-enum-case-by-name-or-throw)
      - [`tryFromName()` — Get any enum case by name or null](#tryfromname--get-any-enum-case-by-name-or-null)
  - [`AsMetadableEnum`](#AsMetadableEnum)
    - [Apply the trait on your enum](#apply-the-trait-on-your-enum-6)
    - [Access the Metadata](#access-the-metadata)
    - [Creating Meta Properties](#creating-meta-properties)
      - [Custom method name — Override `customMethodName()` to change the accessor](#custom-method-name--override-custommethodname-to-change-the-accessor)
      - [Value transformation — Override `transform()` to modify the stored value](#value-transformation--override-transform-to-modify-the-stored-value)
      - [Default value — Override `defaultValue()` to set a default value](#default-value--override-defaultvalue-so-cases-without-the-attribute-still-return-a-value)
    - [`fromMeta()` — Get the first case matching a meta value or throw](#frommeta--get-the-first-case-matching-a-meta-value-or-throw)
    - [`tryFromMeta()` — Get the first case matching a meta value or null](#tryfrommeta--get-the-first-case-matching-a-meta-value-or-null)
    - [Included Meta Properties](#included-meta-properties)
      - [Description](#description)
      - [Group](#group)
      - [Label](#label)
    - [Recommandations](#recommendation-use-annotations-and-traits)
  - [`AsSelfAwareableEnum`](#asselfawareableenumtrait)
      - [Apply the trait on your enum](#apply-the-trait-on-your-enum-7)
      - [`isPure()` — Check if the enum is a pure enum (no backing type)](#ispure--check-if-the-enum-is-a-pure-enum-no-backing-type)
      - [`isBacked()` — Check if the enum is backed](#isbacked--check-if-the-enum-is-backed)
      - [`isBackedByInteger()` — Check if the enum is backed by `int`](#isbackedbyinteger--check-if-the-enum-is-backed-by-int)
      - [`isBackedByString()` — Check if the enum is backed by `string`](#isbackedbystring--check-if-the-enum-is-backed-by-string)
  - [`AsStringSelectableEnum`](#asstringselectableenum)
    - [Apply the trait on your enum](#apply-the-trait-on-your-enum-8)
    - [`stringOptions()` — Generate a formatted string from enum cases](#stringoptions--generate-a-formatted-string-from-enum-cases)
- [PHPStan](#phpstan)
- [Development](#development)
- [Todo](#todo)


## Installation

PHP 8.3+ is required.

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

Get the value of a backed enum, or the name of a pure enum, by "invoking" it — either statically (`BackedEnum::THREE()` instead of `BackedEnum::THREE->value`), or as an instance (`$enum()`).

Use enums as array keys without appending `->value`:

```php
'statuses' => [
    TaskStatus::INCOMPLETE() => ['some configuration'],
    TaskStatus::COMPLETED() => ['some configuration'],
],
```

Or pass primitive values directly:

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

Returns a list of case **names** in the enum.

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

Returns a list of case **values** for backed enums, or a list of case **names** for pure enums.

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

Returns an associative array of `[case name => case value]` for backed enums, or an indexed array of names for pure enums.

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

Compare enum cases using fluent instance methods and static helpers.

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

#### `is()` — Check if the case matches a target

```php
TaskStatus::INCOMPLETE->is(TaskStatus::INCOMPLETE); // true
TaskStatus::INCOMPLETE->is(TaskStatus::COMPLETED); // false
Role::ADMINISTRATOR->is(Role::ADMINISTRATOR); // true
Role::ADMINISTRATOR->is(Role::NOBODY); // false
```

#### `isNot()` — Check if the case does not match a target

```php
TaskStatus::INCOMPLETE->isNot(TaskStatus::INCOMPLETE); // false
TaskStatus::INCOMPLETE->isNot(TaskStatus::COMPLETED); // true
Role::ADMINISTRATOR->isNot(Role::ADMINISTRATOR); // false
Role::ADMINISTRATOR->isNot(Role::NOBODY); // true
```

#### `in()` — Check if the case is in a list of targets

```php
TaskStatus::INCOMPLETE->in([TaskStatus::INCOMPLETE, TaskStatus::COMPLETED]); // true
TaskStatus::INCOMPLETE->in([TaskStatus::COMPLETED, TaskStatus::CANCELED]); // false
Role::ADMINISTRATOR->in([Role::ADMINISTRATOR, Role::GUEST]); // true
Role::ADMINISTRATOR->in([Role::SUBSCRIBER, Role::GUEST]); // false
```

#### `notIn()` — Check if the case is not in a list of targets

```php
TaskStatus::INCOMPLETE->notIn([TaskStatus::INCOMPLETE, TaskStatus::COMPLETED]); // false
TaskStatus::INCOMPLETE->notIn([TaskStatus::COMPLETED, TaskStatus::CANCELED]); // true
Role::ADMINISTRATOR->notIn([Role::ADMINISTRATOR, Role::GUEST]); // false
Role::ADMINISTRATOR->notIn([Role::SUBSCRIBER, Role::GUEST]); // true
```

#### `has()` — Check if the enum includes a given target (static)

```php
TaskStatus::has(TaskStatus::INCOMPLETE); // true
```

#### `doesntHave()` — Check if the enum does not include a given target (static)

```php
TaskStatus::doesntHave(TaskStatus::INCOMPLETE); // false
```

#### `equalsOneOf()` — Check if the case matches any case in an array

```php
TaskStatus::INCOMPLETE->equalsOneOf([TaskStatus::INCOMPLETE, TaskStatus::COMPLETED]); // true
```

#### `notEqualsOneOf()` — Check if the case does not match any case in an array

```php
TaskStatus::INCOMPLETE->notEqualsOneOf([TaskStatus::COMPLETED, TaskStatus::CANCELED]); // true
```


### AsFromambleEnum

Adds `from()` and `tryFrom()` to **pure** enums, and adds `fromName()` and `tryFromName()` to **all** enums.

#### Important Notes:
* 
* `BackedEnum` instances already implement their own `from()` and `tryFrom()` methods, which will not be overridden by this trait. 
* For pure enums, `from()` and `tryFrom()` are functionally equivalent to `fromName()` and `tryFromName()`.

#### Apply the trait on your enum

```php
use Phil\Enums\AsFromambleEnumTrait;

enum TaskStatus: int
{
    use AsFromambleEnumTrait;

    case INCOMPLETE = 0;
    case COMPLETED = 1;
    case CANCELED = 2;
}

enum Role
{
    use AsFromambleEnumTrait;

    case ADMINISTRATOR;
    case SUBSCRIBER;
    case GUEST;
}
```

#### `from()` — Get a pure enum case by name or throw

```php
Role::from('ADMINISTRATOR'); // Role::ADMINISTRATOR
Role::from('NOBODY'); // Error: ValueError
```

#### `tryFrom()` — Get a pure enum case by name or null

```php
Role::tryFrom('GUEST'); // Role::GUEST
Role::tryFrom('NEVER'); // null
```

#### `fromName()` — Get any enum case by name or throw

```php
TaskStatus::fromName('INCOMPLETE'); // TaskStatus::INCOMPLETE
TaskStatus::fromName('MISSING'); // Error: ValueError
Role::fromName('SUBSCRIBER'); // Role::SUBSCRIBER
Role::fromName('HACKER'); // Error: ValueError
```

#### `tryFromName()` — Get any enum case by name or null

```php
TaskStatus::tryFromName('COMPLETED'); // TaskStatus::COMPLETED
TaskStatus::tryFromName('NOTHING'); // null
Role::tryFromName('GUEST'); // Role::GUEST
Role::tryFromName('TESTER'); // null
```


### AsMetadableEnum

Attach metadata to enum cases using PHP attributes.

#### Apply the trait on your enum

```php
use App\Enums\MetaProperties\Color;
use Phil\Enums\AsMetadableEnumTrait;
use Phil\Enums\Attribute\Description;
use Phil\Enums\Attribute\Meta;

#[Meta(Description::class, Color::class)]
enum TaskStatus: int
{
    use AsMetadableEnumTrait;

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
- The `#[Meta]` attribute on the enum declares which meta properties are enabled
- Each case must have the declared meta properties applied (unless the meta property defines a `defaultValue()`)

#### Access the metadata

```php
TaskStatus::INCOMPLETE->description(); // 'Incomplete Task'
TaskStatus::COMPLETED->color(); // 'green'
```

#### Creating meta properties

Each meta property is a class extending `AbstractMetaProperty`:

```php
#[Attribute]
class Color extends AbstractMetaProperty {}

#[Attribute]
class Description extends AbstractMetaProperty {}
```

Inside the class, you can customize a few things.

##### Custom method name — Override `customMethodName()` to change the accessor

For instance, you may want to use a different method name than the one derived from the class name (`Description` becomes `description()` by default).

To do that, override the `method()` method on the meta property:

```php
#[Attribute]
class Description extends AbstractMetaProperty
{
    public static function customMethodName(): ?string
    {
        return 'note';
    }
}
```

With the code above, the description of a case will be accessible as `TaskStatus::INCOMPLETE->note()`.

#### Value transformation — Override `transform()` to modify the stored value

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

##### Default value — Override `defaultValue()` so cases without the attribute still return a value

You can also add a `defaultValue()` method to specify the value a case should have if it doesn't use the meta property. That way you can apply the attribute only on some cases and still get a configurable default value on all other cases.


#### `fromMeta()` — Get the first case matching a meta value or throw

```php
TaskStatus::fromMeta(Color::make('green')); // TaskStatus::COMPLETED
TaskStatus::fromMeta(Color::make('blue')); // Error: ValueError
```

#### `tryFromMeta()` — Get the first case matching a meta value or null

```php
TaskStatus::tryFromMeta(Color::make('green')); // TaskStatus::COMPLETED
TaskStatus::tryFromMeta(Color::make('blue')); // null
```

#### Included Meta Properties

The package ships with three ready-to-use meta properties:

##### Description

This attribute is a Single Value 

##### Group

This attribute is Repeatable

##### Label

This attribute is a Single Value

#### Recommendation: use annotations and traits

For better IDE support, add `@method` annotations:

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

If you reuse the same meta property across multiple enums, create a dedicated trait with the `@method` annotation.


### AsSelfAwareableEnum

Introspect the nature of your enum at runtime.

#### Apply the trait on your enum

```php
use Phil\Enums\AsSelfAwareableEnumTrait;

enum TaskStatus: int
{
    use AsSelfAwareableEnumTrait;

    case INCOMPLETE = 0;
    case COMPLETED = 1;
    case CANCELED = 2;
}

enum Role
{
    use AsSelfAwareableEnumTrait;

    case ADMINISTRATOR;
    case SUBSCRIBER;
    case GUEST;
}
```

#### `isPure()` — Check if the enum is a pure enum (no backing type)

```php
Role::isPure(); // true
TaskStatus::isPure(); // false
```

#### `isBacked()` — Check if the enum is backed

```php
TaskStatus::isBacked(); // true
Role::isBacked(); // false
```

#### `isBackedByInteger()` — Check if the enum is backed by `int`

```php
TaskStatus::isBackedByInteger(); // true
```

#### `isBackedByString()` — Check if the enum is backed by `string`

```php
TaskStatus::isBackedByString(); // false
```


### AsStringSelectableEnum

Generate string representations of your enum options. This trait also includes `AsSelectableEnumTrait`.

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

#### `stringOptions()` — Generate a formatted string from enum cases

```php
// First argument is the callback, second argument is glue
TaskStatus::stringOptions(fn ($name, $value) => "$name => $value", ', '); // "INCOMPLETE => 0, COMPLETED => 1, CANCELED => 2"
```

For pure enums (non-backed), the name is used in place of `$value` (meaning that both `$name` and `$value` are the same).

Both arguments are optional. The default glue is `\n` and the default callback generates HTML `<option>` tags:

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

To assist PHPStan when using invokable cases and metadata methods, include the PHPStan extension in your `phpstan.neon`:

```yaml
includes:
  - ./vendor/ph-il/enums/extension.neon
```

> [!NOTE]
> If you have [`phpstan/extension-installer`](https://github.com/phpstan/extension-installer) installed, the extension is included automatically.


## Development

Run all checks locally:

```sh
castor ci:all
```

Code style will be automatically fixed by php-cs-fixer.


## Todo

* Version 0.3.0 
  * Add operations
    * count
    * Add Filtering and Sorting
    * first
      * with or without filter via callback


## License

MIT. See [LICENSE](LICENSE) for details.


[ico-author]: https://img.shields.io/badge/author-ph--il-blue?logo=github&style=flat&logoSize=auto
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
