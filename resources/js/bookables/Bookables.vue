<template>
    <div>
        <BookableListItem></BookableListItem>
    </div>
</template>


<script>

//We import and declare ('export component') BookablesListItem component locally in this parent component (Bookables). 
//To delcare a component globally we would do it in the app.js.
import BookableListItem from "./BookablesListItem";

export default {
    components: {
        BookableListItem //This allows us to use the component in either PacalCase or kebab-case
    }
}
</script>