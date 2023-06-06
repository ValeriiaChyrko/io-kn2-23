<template>
    <div>
        Кабінет
    </div>
</template>

<script>
export default {
    middleware: 'auth',

    metaInfo() {
        return { title: "Дома" };
    }
};
</script>
