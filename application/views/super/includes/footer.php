            </div>
            <!-- /#page-content-wrapper -->

        </div>
        <!-- /#wrapper -->

        <script type="text/javaScript" src="<?php echo site_url('private/js/bootstrap.min.js'); ?>"></script>

        <!-- All plugins -->
        <script type="text/javaScript" src="<?php echo site_url('private/plugins/bootstrap-fileinput-master/js/fileinput.min.js') ;?>"></script>
        <!-- <script type="text/javaScript" src="<?php //echo site_url('private/plugins/peity/jquery.peity.min.js')?>"></script> -->

    	<!-- Nice Scroll -->
    	<script src="<?php echo site_url('private/js/jquery.nicescroll.min.js'); ?>"></script>

        


        <!-- Menu Toggle Script -->
        <script type="text/javaScript">
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
                $("#wrapper").toggleClass("toggled");
                $(this).toggleClass("icon-change");
            });

            $(function () {
                $('#datetimepicker1').datetimepicker({
                    format: 'YYYY-MM-DD'
                });

                // charte

                // var updatingChart = $(".bar").peity("bar", {
                // width: 200,
                // height: 100
            });
            // setInterval(function() {
            //     var random = Math.round(Math.random() * 10);
            //     var values = updatingChart.text().split(",");
            //     values.shift();
            //     values.push(random);
            //
            //     updatingChart.text(values.join(",")).change();
            // }, 1000);

                // $(".bar1").peity("bar");
                //
                // $("span.pie").peity("pie");
                //
                // $(".data-attributes span").peity("donut")


                // linking between two date
                $('#datetimepickerFrom').datetimepicker();
                $('#datetimepickerTo').datetimepicker({
                    useCurrent: false
                });
                $("#datetimepickerFrom").on("dp.change", function (e) {
                    $('#datetimepickerTo').data("DateTimePicker").minDate(e.date);
                });
                $("#datetimepickerTo").on("dp.change", function (e) {
                    $('#datetimepickerFrom').data("DateTimePicker").maxDate(e.date);
                });

            // file upload with plugin options
            $("input#input").fileinput({
                browseLabel: "Pick Image",
                previewFileType: "text",
                allowedFileExtensions: ["jpg", "jpeg", "png"],
            });




        </script>

        <script>
        $(document).on('ready', function() {
            $("#input-4").fileinput({showCaption: false});
        });
        </script>
    </body>
</html>
