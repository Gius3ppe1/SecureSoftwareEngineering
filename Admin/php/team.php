<?php
$conn = mysqli_connect ("localhost", "root", "","civicsense") or die ("Connessione non riuscita"); 

$sql = mysqli_query($conn,"SELECT * FROM team");


    // output data of each row
    while($row = mysqli_fetch_assoc($sql)) {
        echo "
		<tr>
              <td>" . htmlspecialchars($row['codice']) . "<br></td>
              <td>" . htmlspecialchars($row['email_t']) . "<br></td>
              <td>" . htmlspecialchars($row['nomi']) . "<br></td>
               
          </tr> ";
    }
?>