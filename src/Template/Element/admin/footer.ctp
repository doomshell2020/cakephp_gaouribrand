<footer class="main-footer">
    <strong>Copyright &copy; <?php echo date('Y') . "-" . (date('Y') + 1); ?><a href="#"> Gaouri Brand</a>.</strong> All rights
    reserved.
</footer>
<div class="lds-facebook" style="display:none">
    <div class="loader_relate">
        <div class="loader_abs">
            <div class="div_pos">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
        <p>Please Wait For Best Result</p>
    </div>
</div>

</div>
<!-- ./wrapper -->
<script
    src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
    crossorigin="anonymous"></script>
<!-- AdminLTE App -->
<?= $this->Html->script('admin/app.min.js') ?>
<!-- FastClick -->
<?= $this->Html->script('admin/fastclick.js') ?>
<?= $this->Html->script('admin/jquery.dataTables.min.js') ?>
<?= $this->Html->script('admin/dataTables.bootstrap.min.js') ?>
<?= $this->Html->script('admin/jquery-ui.js') ?>

<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote();
    });
</script>


<!-- Commented the following line 60 and used the line 61 following it instead -->
<!-- <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
<?php echo $this->Html->css('admin/jquery-ui.css'); ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $(function() {
        $("#example1").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>
</body>

</html>

<div class="modal fade" id="globalModal" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content personal">
            <div class="modal-body">
                <div class="col-sm-6 col-md-6 col-sm-offset-2 col-md-offset-2">
                </div>
                <div class="loader">
                    <div class="es-spinner">
                        <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        //prepare the dialog

        //respond to click event on anything with 'overlay' class
        $(".globalModals").click(function(event) {

            // alert($(this).attr("href"));

            $('.modal-content').load($(this).attr("href")); //load content from href of link

        });
    });
</script>



<!--modal & script for Add Bag Weight -->
<div class="modal fade" id="globalModalbag" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content personal">
            <div class="modal-body">
                <div class="col-sm-6 col-md-6 col-sm-offset-2 col-md-offset-2">
                </div>
                <div class="loader">
                    <div class="es-spinner">
                        <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        //prepare the dialog

        //respond to click event on anything with 'overlay' class
        $(".globalModalbag").click(function(event) {

            // alert($(this).attr("href"));

            $('.modal-content').load($(this).attr("href")); //load content from href of link

        });
    });
</script>


<!--modal & script for Add Bag Weight on edit-->
<div class="modal fade" id="globalModalsedit" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content personal">
            <div class="modal-body">
                <div class="col-sm-6 col-md-6 col-sm-offset-2 col-md-offset-2">
                </div>
                <div class="loader">
                    <div class="es-spinner">
                        <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        //prepare the dialog

        //respond to click event on anything with 'overlay' class
        $(".globalModalsedit").click(function(event) {

            // alert($(this).attr("href"));

            $('.modal-content').load($(this).attr("href")); //load content from href of link

        });
    });
</script>


<!--modal & script for Add Bag Weight on edit-->
<div class="modal fade" id="globalModalsrackadd" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content personal">
            <div class="modal-body">
                <div class="col-sm-6 col-md-6 col-sm-offset-2 col-md-offset-2">
                </div>
                <div class="loader">
                    <div class="es-spinner">
                        <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        //prepare the dialog

        //respond to click event on anything with 'overlay' class
        $(".globalModalsedit").click(function(event) {

            // alert($(this).attr("href"));

            $('.modal-content').load($(this).attr("href")); //load content from href of link

        });
    });
</script>
<!--modal & script for Add Bag Weight on edit-->
<div class="modal fade" id="globalModalsrackedit" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content personal">
            <div class="modal-body">
                <div class="col-sm-6 col-md-6 col-sm-offset-2 col-md-offset-2">
                </div>
                <div class="loader">
                    <div class="es-spinner">
                        <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--modal & script for Add Bag Weight on edit-->
<div class="modal fade" id="globalModalsrackadds" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content personal">
            <div class="modal-body">
                <div class="col-sm-6 col-md-6 col-sm-offset-2 col-md-offset-2">
                </div>
                <div class="loader">
                    <div class="es-spinner">
                        <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        //prepare the dialog

        //respond to click event on anything with 'overlay' class
        $(".globalModalsedit").click(function(event) {

            // alert($(this).attr("href"));

            $('.modal-content').load($(this).attr("href")); //load content from href of link

        });
    });
</script>

<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<!-- <script src="https://code.jquery.com/jquery-3.4.1.js"></script> -->

<script type="text/javascript">
    function ismobile(e) {
        var e = e || window.event;
        var k = e.which || e.keyCode;
        var s = String.fromCharCode(k);
        if (/^[\\\"\'\;\:\>\]\[\<\.\,\-\/\?\=\+\_\|~`!@#\$%^&*\(\)a-z A-Z]$/i.test(s)) {
            $('#mobilee').css('display', 'block');
            return false;
        }
        $('#mobilee').hide();
    }
</script>