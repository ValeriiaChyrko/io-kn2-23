<template>
    <v-tooltip top>
        <template #activator="{ on, attrs }">
            <span
                v-on="on"
                v-bind="attrs"
            >
                {{ truncatedComment }}
            </span>
        </template>

        <span>{{ comment }}</span>
    </v-tooltip>
</template>

<script>
const MAX_COMMENT_LENGTH = 20;

export default {
    name: 'RepairComment',
    props: {
        comment: {
            type: String,
            default: null
        }
    },
    computed: {
        truncatedComment: function() {
            if((this.comment ?? '').length > MAX_COMMENT_LENGTH) {
                return this.comment.substring(0, MAX_COMMENT_LENGTH) + '...';
            }
            return this.comment;
        }
    }
};
</script>
