
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  
<?php

  $theData = file('affiliates.txt');

?>

<div class="container">
    
  <table class="table table-bordered table-sm">
    <thead>
      <tr>
      <th>Sr. No.</th>
        <th>Affiliate Id</th>
        <th>Name</th>
        <th>Kilometers</th>
      </tr>
    </thead>
    <tbody> 
      <?php
      $cnt=1;
      $data1 = array();
      $result_array[] = [];
      foreach ($theData as $line) {
    
        $data = json_decode($line);

        $data1 = array(
          'affiliate_id' =>  $data->affiliate_id,
          'latitude' =>  $data->latitude,
          'longitude' => $data->longitude,
          'name' => $data->name,
        
        );

        $stack = $result_array;
        $data1 = array($data1);
      
        $result_array= array_merge($stack, $data1);
      }

      usort($result_array, function($a,$b){return $a['affiliate_id']-$b['affiliate_id'];});

      foreach ($result_array as $line)
      {
        
        $office_lat= "53.3340285";
        $office_long= "-6.2535495";
        $dist_lat= $line['latitude'] ;
        $dist_long= $line['longitude'];
        $dist_affiliate_id= $line['affiliate_id'];
        $dist_name= $line['name'];
         
        if (($office_lat == $dist_lat) && ($office_long == $dist_long)) {
          $distance = 0;
        }
        else {
          $theta = $office_long - $dist_long;
          $dist = sin(deg2rad($office_lat)) * sin(deg2rad($dist_lat)) +  cos(deg2rad($office_lat)) * cos(deg2rad($dist_lat)) * cos(deg2rad($theta));
          $dist = acos($dist);
          $dist = rad2deg($dist);
          $miles = $dist * 60 * 1.1515;
          $distance= ($miles * 1.609344);

        }

        if ( $distance <= 100){
          ?> 
          <tr>
          <td><?php echo $cnt; ?></td>
            <td><?php echo $line['affiliate_id']; ?></td>
            <td><?php echo $line['name']; ?></td>
            <td><?php echo $distance; ?></td>
          </tr>
          <?php
          $cnt++; 
        }
      } ?>
    </tbody>
  </table>
</div>



