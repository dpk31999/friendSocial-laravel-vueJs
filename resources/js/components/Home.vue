<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <ListFriend></ListFriend>
                <ListRequestFriend></ListRequestFriend>
                <ListPost></ListPost>
            </div>
            <div class="col-md-4 d-none d-md-block">
                <Info></Info>
            </div>
        </div>
    </div>
</template>
<script>

import ListPost from './home/ListPost'
import ListFriend from './home/ListFriend'
import ListRequestFriend from './home/ListRequestFriend'
import Info from './home/Info'

export default {
    components: {
        ListPost,
        ListFriend,
        ListRequestFriend,
        Info
    }
}
</script>
<style scoped>

</style>