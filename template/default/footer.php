<script src="/libs/jquery/jquery.min.js"></script>
<script src="/libs/jquery/jquery-ui/js/jquery-ui.min.js"></script>
<script src="/libs/bootstrap/js/bootstrap.min.js"></script>
<script src="/libs/charts/charts.min.js"></script>
<script src="/libs/jquery/datepicker/js/datepicker.min.js"></script>
<script src="/libs/angular/angular.min.js"></script>
<script src="/libs/jquery/datepicker/js/jquery.datetimepicker.full.js"></script>

<?php
if(isset($js)){
    foreach($js as $item){
        echo "\n\t<script src=\"/resources/$session/js/$item\"></script>\n";
    }
}
?>
</body>
</html>
