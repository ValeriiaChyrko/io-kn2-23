<template>
    <loading-icon v-if="saving" :hide-tooltip="hideTooltip"/>
    <missing-on-server-icon v-else-if="!exists" :hide-tooltip="hideTooltip"/>
    <saved-icon v-else-if="showSavedIcon" :hide-tooltip="hideTooltip"/>
    <blank-icon v-else/>
</template>

<script>
import BlankIcon from '~/components/Forms/Invoice/LoadStatusIcon/BlankIcon';
import LoadingIcon from '~/components/Forms/Invoice/LoadStatusIcon/LoadingIcon';
import SavedIcon from '~/components/Forms/Invoice/LoadStatusIcon/SavedIcon';
import MissingOnServerIcon from '~/components/Forms/Invoice/LoadStatusIcon/MissingOnServerIcon';

export default {
    name: 'LoadStatusIcon',
    components: {
        BlankIcon,
        LoadingIcon,
        MissingOnServerIcon,
        SavedIcon
    },
    props: {
        saving: {
            type: Boolean,
            required: true
        },
        exists: {
            type: Boolean,
            required: true
        },
        hideTooltip: {
            type: Boolean,
            default: false
        }
    },
    data: () => ({
        showSavedIcon: false
    }),
    watch: {
        saving(newValue) {
            if(newValue === false) {
                this.showSavedIcon = true;

                setTimeout(() => {
                    this.showSavedIcon = false;
                }, 3500);
            }
        }
    }
};
</script>
