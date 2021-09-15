<template>
    <textarea v-if="type === 'textarea'" :placeholder="placeholder" :name="name" :id="id" :type="type" :class="cls" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)">
    </textarea>
    <input v-else-if="type === 'checkbox'" :name="name" :id="id" type="checkbox" :class="cls" :checked="checked" @input="(event) => $emit('update:checked', event.target.checked)" />

    <select v-else-if="type === 'dropdown'" :name="name" :id="id" :type="type" :class="cls" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)">
        <slot></slot>
    </select>
    <input v-else :placeholder="placeholder" :name="name" :id="id" :type="type" :class="cls" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" />
</template>

<script>
export default {
    props: {
        cls: String,
        placeholder: String,
        name: String,
        id: String,
        type: String,
        modelValue: String,
        checked: {
            type: Boolean,
        },
    },
    emits: ["update:modelValue"],
};
</script>
<style lang="scss" scoped></style>
