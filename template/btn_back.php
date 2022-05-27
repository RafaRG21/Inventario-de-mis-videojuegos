<p class="has-text-centered">
    <a href="#" class="button is-link isrounded btn-back"><i class="bi bi-chevron-double-left"></i>Regresar</a>
</p>

<script type="text/javascript">
    let btn_back = document.querySelector(".btn-back");

    btn_back.addEventListener('click',function(e){
        e.preventDefault();
        window.history.back();
    });
</script>