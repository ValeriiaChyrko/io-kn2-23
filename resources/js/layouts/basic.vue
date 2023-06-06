<template>
    <div class="full-height d-flex align-center justify-center">
        <child/>
    </div>
</template>

<script>
export default {
    name: 'BasicLayout'
};
</script>

<style lang="scss" scoped>
.full-height {
  height: 100vh;
}
</style>
