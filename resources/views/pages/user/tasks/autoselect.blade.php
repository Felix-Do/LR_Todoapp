<script>
    let autoselect_elements = document.getElementsByClassName("autoselect");
    let length = autoselect_elements.length;
    if ( length >= 1 ) {
        autoselect_elements[length-1].select();
    }
</script>