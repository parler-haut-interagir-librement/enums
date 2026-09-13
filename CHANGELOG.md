# Changelog

All notable changes to `enum` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](https://keepachangelog.com/) principles.


## NEXT - YYYY-MM-DD

### Added
- Nothing

### Changed
- Nothing

### Deprecated
- Nothing

### Fixed
- Nothing

### Removed
- Nothing

### Security
- Nothing


## 0.2.2 - 2026-09-13

### Added
- `AbstractMetaProperty` is now generic over its value type (`@template TValue`). Meta properties declare
  what they hold with `@extends AbstractMetaProperty<string>` (done for Description, Group and Label)

### Changed
- The PHPStan extension now infers the real return type of the generated meta accessors
  (`->label()`, `->description()`, ...) from the meta property's `TValue`, instead of always reporting `mixed`
- An accessor is only nullable when at least one case of the enum lacks the attribute and can therefore
  fall back to `defaultValue()`; an enum that attributes every case gets the bare value type
- `Meta`, `Meta\Reflection` and `AsMetadatableEnumTrait` signatures updated for the generic `AbstractMetaProperty`


## 0.2.1 - 2026-04-15

### Fixed
- Add Attribute::TARGET_CLASS_CONSTANT to the Meta Attributes (Description, Group, Label)
- Fix link in documentation

## 0.2.0 - 2026-03-01

### Added
- Label Meta Property
- Add equalsOneOf and notEqualsOneOf in AsComparableEnumTrait
- Add AsSelfAwareableEnumTrait : self-awareness 
  * isPure
  * isBacked
  * isBackedByInteger
  * isBackedByString
- Add PHPStan Extensions
- Add Tests
- Add Castor as Runner

### Changed
- Documentation

### Fixed
- Documentation
- All PHPStan Errors
- Fixes all CS problems

## 0.1.0 - 2026-02-19

### Added
- First implementation of the package
- AsComparableEnumTrait
- AsFromambleEnumTrait
- AsInvocableEnumTrait
- AsMetadableEnumTrait
- AsNameableEnumTrait
- AsValuableEnumTrait
- AsSelectableEnumTrait
- AsStringSelectableEnumTrait
- AsEnumerableEnumTrait
- Meta
  - Description
  - Group
