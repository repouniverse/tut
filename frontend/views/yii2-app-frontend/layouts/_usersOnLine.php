<div class="table-responsive">
     <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Usuario</th>
                   
                  </tr>
                  </thead>
                  <tbody>
                      
                   <?php
            $usersArray= common\models\Useraudit::UsersInLine();
           foreach($usersArray as $User){               
               ?>
              <tr>  
                  <td>
               <?=$User['username'];?>
                  </td>
                    
              </tr> 
           <?php } ?>   
                      
               
                  
                  </tbody>
    </table>

</div>

