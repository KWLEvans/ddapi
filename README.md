# Data Structure
---

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
