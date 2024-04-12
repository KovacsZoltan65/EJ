<script setup>
    import { ref } from 'vue';
    const props = defineProps({
        modelValue: {
            type: String,
            required: true,
            validator: (value) => {
                //return value.length > 0;
                return true;
            },
            default: ''
        },
        // lista elemeinek tömbje
        options: {
            type: Array,
            required: true,
            validator: (value) => {
                //return value.length > 0;
                return true;
            },
            default: () => ({})
        },
        // kiválasztandó elemek tömbje
        selected: {
            type: Array,
            required: false,
            default: () => ({})
        },
        first_row: {
            type: Boolean,
            required: false,
            default: true
        }
    });

    const input = ref(null);

    defineExpose({ focus: () => input.value.focus() });

    const compare = (option) => {
        var retval = false;
        //console.log('option 1: ' + option.name);
        //console.log(props.selected[0].name);
        props.selected.forEach( (sel) => {
            //console.log('option 2:'+ sel.name);
            retval = (sel.name === option.name);
        } );

        return retval;
    };
    
</script>

<template>
    <select>
        <option v-if="first_row" value="0">VÁLASSZ</option>
        <option 
            v-for="option in options" 
            :key="option.id" 
            :value="option.id" 
            :selected="compare(option)"
        >{{ option.name }}</option>
    </select>
</template>