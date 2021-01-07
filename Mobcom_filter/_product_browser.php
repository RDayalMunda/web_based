<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MobCOM Shopping</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


</head>
<body>
    <h1>Happy Shopping</h1>
    <form method="GET">
        <input type="text" name="search_string" id="search_string">
        <br>Filter by 
        <select id='brand_list' name='brand'>
            <option> error  cured</option>
        </select>
        <br>Filter by RAM:
        <select name="filter_ram_operation" id="ram_operation" onchange='ram_filter(this.value)'>
            <option value="">No</option>
            <option value='>=' id="ram_larger">RAM greater than =</option>
            <option value='<=' id="ram_smaller">RAM smaller than =</option>
        </select>
        <input type="number" name="ram_size" id="ram_size" value='0' hidden> GB
        <br>Filter by ROM:
        <select name="filter_rom_operation" id="rom_operation" onchange='rom_filter(this.value)'>
            <option value="">No</option>
            <option value='>=' id='rom_larger'>RO greater than =</option>
            <option value='<=' id='rom_smaller'>ROM smaller than =</option>
        </select>
        <input type="number" name="rom_size" id="rom_size" value='0' hidden> GB
        </select>
        <br>
        <input type="number" name="page_number" id="page_number" value=1 hidden>
        <br>
        <input type="submit" name="go" id="go">
    </form>








    <?php
        $items_per_page = 4;
        $page_number = 1;
        $conn = mysqli_connect('localhost', 'root', '', 'mobcom');

        //setup for query filtering
        $myquery = "SELECT * FROM `products_master`"; 
        if (isset($_GET['go'])){

            /// here is query generation for string searching 
            $search_string = $_GET['search_string'];
            $myquery = $myquery . " Where (";

            /// for the search bar
            $search_words = explode(' ', $search_string);
            for ($i=0; $i<count($search_words); $i++){
                if ($search_words[$i]=='' && $i != 0){
                    continue;
                }
                if ($i != 0){
                    $myquery = $myquery. " AND";
                }
                $myquery = $myquery . " CONCAT(`brand_name`, `model_name`, `ram`, `rom`, `battery`, `price`) LIKE '%$search_words[$i]%'";
            }
            $myquery = $myquery . ")";

            //we want to retain the string in the search bar
            echo "<script>";
            echo "document.getElementById('search_string').value='$search_string';</script>";

            ///here is filtering with brand
            $brand = $_GET['brand'];
            if ($brand != ''){
                $myquery = $myquery ." AND `brand_name`=" . "'$brand'";
            }
        
            ///here is filtering by ram size
            $ram_limit = $_GET['ram_size'];
            $ram_limit = $ram_limit *1024;
            $ram_op = $_GET['filter_ram_operation'];
            if ($ram_op == '>='){
                $myquery = $myquery . " AND `ram` >= ". "'$ram_limit'";
            }elseif ($ram_op == '<='){
                $myquery = $myquery . " AND `ram` <= ". "'$ram_limit'";
            }
            
            ///here is filtering by rom size
            $rom_limit = $_GET['rom_size'];
            $rom_limit = $rom_limit *1024;
            $rom_op = $_GET['filter_rom_operation'];
            if ($rom_op == '>='){
                $myquery = $myquery . " AND `rom` >= ". "'$rom_limit'";
            }elseif ($rom_op == '<='){
                $myquery = $myquery . " AND `rom` <= ". "'$rom_limit'";
            }

            ///pagination concept here
            $results = $conn->query($myquery);
            $total_items = mysqli_num_rows($results);
            $last_page = $total_items / $items_per_page;
            $last_page = ceil($last_page);
            //to check the page number and set accordingly
            $page_number = $_GET['page_number'];
            if ($page_number == '' or $page_number < 1 or $page_number > $last_page){
                $page_number = 1;
            }
            //setting queryy
            echo "<script>document.getElementById('page_number').value='$page_number';";
            echo "</script>\n\n";
            



        }


        ///pagintaion here
        $results = $conn->query($myquery);
        $total_items = mysqli_num_rows($results);
        $starting = $page_number -1;
        $length = $items_per_page;
        $last_page = $total_items / $items_per_page;
        $last_page = ceil($last_page);
        if ($page_number *$items_per_page > $total_items){
            $length = $total_items -$starting * $items_per_page;
        }
        $starting = $items_per_page * $starting;
        //echo "starting = $starting<br>length = $length";
        //query edit to show only what part of the total output
        $myquery = $myquery . "LIMIT $starting, $length";
        
        $page_prev = $page_number -1;
        $page_prevprev = $page_number -2;
        $page_next = $page_number +1;
        $page_nextnext = $page_number +2;
        ///page buttons here
        echo "\n<center><ul class='pagination'>";
        if ($page_number > 1){
            echo "<li class='page-item' value='$page_prev' onclick='change_page(this.value)'><a>Previous</a></li>";
        }
        if ($page_number > 2){
            echo "<li class='page-item' value='$page_prevprev' onclick='change_page(this.value)'><a>Page $page_prevprev</a></li>";
        }
        if ($page_number > 1){
            echo "<li class='page-item' value='$page_prev' onclick='change_page(this.value)'><a>Page $page_prev</a></li>";
        }
        echo "<li class='page-item active' value='$page_number' onclick='change_page(this.value)'><a class='btn btn-default'>Page $page_number</a></li>";
        if ($page_number < $last_page){
            echo "<li class='page-item' value='$page_next' onclick='change_page(this.value)'><a>Page $page_next</a></li>";
        }
        if ($page_next < $last_page){
            echo "<li class='page-item' value='$page_nextnext' onclick='change_page(this.value)'><a>Page $page_nextnext</a></li>";
        }
        if ($page_number < $last_page){
            echo "<li class='page-item' value='$page_next' onclick='change_page(this.value)'><a class='btn btn-danger'>Next</a></li>";
        }
        echo "\n</ul>\n";


        echo "<h3>total items = $total_items</h3>";
        ////DISPLAYING THE FINAL query and filtering
        //echo "<br><br><h3>$myquery</h3>";
        $results = $conn->query($myquery);
        $total_items = mysqli_num_rows($results);
        echo "\n\n<table width=50%><tr><thead><th>Brand</th><th>Model</th><th>RAM</th><th>ROM</th><th>Battery</th><th>Price</th></thead></tr>";
        while ($row = mysqli_fetch_array($results)){
            $ram = $row['ram'];
            $ram = $ram /1024;
            $rom = $row['rom'];
            $rom = $rom /1024;

            echo "<tr>";
            echo "<td> $row[brand_name] </td>";
            echo "<td> $row[model_name] </td>";
            echo "<td> $ram GB</td>";
            echo "<td> $rom GB</td>";
            echo "<td> $row[battery] mAh</td>";
            echo "<td> $row[price] </td>";
            echo "</tr>";
        }
        echo "</table>\n\n";
        
        
        ///to get the brand names from the database for the select 
        $myquery = "SELECT * FROM `products_master` GROUP BY `brand_name`";
        $results = $conn->query($myquery);
        
        echo "\n\n\n<script>\n";
        echo "\tvar brand_list = [\n";
        for($i=0; $i < mysqli_num_rows($results); $i++){
            $row = mysqli_fetch_array($results);
            echo "\t", '"' . $row['brand_name']. '",' ."\n";
        }
        echo "\t];";
        echo "\n</script>\n\n";
    ?>



    <script>
        var txt = '<option value=""> Brand </option>';
        var i;
        for(i=0; i<brand_list.length; i++){
            txt = txt + "<option id='" + brand_list[i] + "'>" + brand_list[i] +"</option>";
        }
        document.getElementById('brand_list').innerHTML = txt;

        ///for the ram filter the input box disables when none is selected and enables back when atleast or altmax is selected
        function ram_filter(value) {
            if (value==0){
                ram_size.hidden = true;
                ram_size.value = '0';
            }else{
                ram_size.hidden = false;
            }
        }

        ///for the rom filter the input box disables when none is selected and enables back when atleast or altmax is selected
        function rom_filter(value) {
            if (value==0){
                rom_size.hidden = true;
                rom_size.value = '0';
            }else{
                rom_size.hidden = false;
            }
        }

        //changin the page
        function change_page(pageto){
            document.getElementById('page_number').value = pageto;
            document.getElementById('go').click();
        }
    </script>


    <?php
    ///to retain the filter from the previous page
        if (isset($_GET['go'])){
            //to retain brand
            if ($_GET['brand']!=''){
                echo "\n<script>\ndocument.getElementById('$brand').selected = true;\n</script>";
            }

            //to retain rom
            if ($_GET['filter_rom_operation'] == '>=') {
                echo "\n<script>\ndocument.getElementById('rom_larger').selected = true;\n";
                echo "document.getElementById('rom_size').value='" .$_GET['rom_size']. "';\n";
                echo "document.getElementById('rom_size').hidden = false;\n</script>";
            }elseif ($_GET['filter_rom_operation'] == '<=') {
                echo "\n<script>\ndocument.getElementById('rom_smaller').selected = true;\n";
                echo "document.getElementById('rom_size').value='" .$_GET['rom_size']. "';\n";
                echo "document.getElementById('rom_size').hidden = false;\n</script>";
            }

            //to retain ram
            if ($_GET['filter_ram_operation'] == '>=') {
                echo "\n<script>\ndocument.getElementById('ram_larger').selected = true;\n";
                echo "document.getElementById('ram_size').value='" .$_GET['ram_size']. "';\n";
                echo "document.getElementById('ram_size').hidden = false;\n</script>";
            }elseif ($_GET['filter_ram_operation'] == '<=') {
                echo "\n<script>\ndocument.getElementById('ram_smaller').selected = true;\n";
                echo "document.getElementById('ram_size').value='" .$_GET['ram_size']. "';\n";
                echo "document.getElementById('ram_size').hidden = false;\n</script>";
            }

        }
        //closing the connection
        $conn->close();
    ?>
</body>
</html>