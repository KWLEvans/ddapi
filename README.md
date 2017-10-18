# Data Structure
---

## RacialAbility

### build:
```php
array(
    'name' => ability name,
    'description' => ability description,
    'id' => unique id
)
```

### buildAll
```php
array(
    racial_ability_build1,
    racial_ability_build2,
...)
```


## Race

### build:
```php
array(
    'name' => race name,
    'flavor' => race flavor text,
    'size' => size string (small, medium, etc.),
    'speed' => int movement value,
    'stats' => array(
        stat_name1,
        stat_name2,
        ...),
    'abilities' => array(
        array(
            'name' => ability name 1,
            'description' => ability description 1,
            'id' => unique racial ability id 1
            ),
        array(
            'name' => ability name 2,
            'description' => ability description 2,
            'id' => unique racial ability id 2
            ),
        ...),
    'id' => unique race id
)
```

### buildAll:
```php
array(
    race_build1,
    race_build2,
...)
```


## Spell

### build:
```php
array(
    'name' => spell name,
    'school' => array(
        'name' => school name,
        'id' => unique school id
        ),
    'level' => int spell level,
    'casting_time' => string spell casting_time,
    'cast_range' => string spell cast_range,
    'components' => string spell components,
    'duration' => string spell duration,
    'description' => text spell description,
    'id' => unique spell id
)
```

### buildAll:
```php
array(
    spell_build1,
    spell_build2,
...)
```
