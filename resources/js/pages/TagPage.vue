<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="tags-page title text">Tags</div>

        </div>
        <div class="row justify-content-center">
            <tag-list></tag-list>
        </div>
    </div>
</template>

<script>
import TagList from '../components/tags/TagListComponent';
export default {
    components: { TagList }
}
</script>

