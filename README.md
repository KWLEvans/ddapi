# Data Structure
---
## Class

### build:
```js
{
    name: (string) class name,
    flavor: (string) flavor text describing class,
    hit_die: (string) hit die (e.g. 'd8'),
    primary_attribute: (string) class primary attribute,
    levels: [
        (object) class_level build 1,
        (object) class_level build 2,
        ...
    ],
    spells: [ (list of spells available to the class)
        (object) spell build 1,
        (object) spell build 2,
        ...
    ],
    proficiencies: [
        [
            name: (string) skill name,
            stat: (string) associated stat,
            id: (int) unique id
        ],
        [
            name: (string) skill name,
            stat: (string) associated stat,
            id: (int) unique id
        ],
        ...
    ],
    saving_throws: [
        [
            name: (string) saving throw name,
            id: (int) unique id
        ],
        [
            name: (string) saving throw name,
            id: (int) unique id
        ],
        ...
    ],
    id: (int) unique class id
}
```


## Race

### build:
```js
{
    name: (string) race name,
    flavor: (string) race flavor text,
    size: (string) size (small, medium, etc.),
    speed: (int) movement value,
    stats: [
        (string) stat_name1,
        (string) stat_name2,
        ...
    ],
    abilities: [
        (object) racial ability build 1,
        (object) racial ability build 2,
        ...
    ],
    id: (int) unique race id
}
```

### buildAll:
```js
[
    (object) race_build1,
    (object) race_build2,
    ...
]
```


## RacialAbility

### build:
```js
{
    name: (string) ability name,
    description: (string) ability description,
    spells: [
        (object) applicable_spell_build1,
        (object) applicable_spell_build2,
        empty if no applicable spells,
        ...
    ],
    id: (int) unique id
}
```

### buildAll
```js
[
    (object) racial_ability_build1,
    (object) racial_ability_build2,
    ...
]
```

### buildByRace
```js
[
    (object) racial_ability_build1,
    (object) racial_ability_build2,
    ...
]
```


## Spell

### build:
```js
{
    name: (string) spell name,
    school: {
        name: (string) school name,
        id: (int) unique school id
    },
    level: (int) spell level,
    casting_time: (string) spell casting_time,
    cast_range: (string) spell cast_range,
    components: (string) spell components,
    duration: (string) spell duration,
    description: (string) spell description,
    id: (int) unique spell id
}
```

### buildAll:
```js
[
    (object) spell_build1,
    (object) spell_build2,
    ...
]
```

### buildByRacialAbility:
```js
[
    (object) spell_build1,
    (object) spell_build2,
    ...
]
```

### buildByClass:
```js
[
    (object) spell_build1,
    (object) spell_build2,
    ...
]
```
