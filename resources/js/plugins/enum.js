export function enumerate($enum, $key = null) {
    let enums = this.$state['enums']

    try {
        return $key !== null
            ? typeof $key === 'string'
                ? enums[$enum][$key.toUpperCase()]
                : Object.values(enums[$enum]).find((item) => item.value === $key).label
            : enums[$enum]
    } catch (e) {
        throw new Error(`Wrong enum type for ${$enum} and key ${$key}`)
    }
}
