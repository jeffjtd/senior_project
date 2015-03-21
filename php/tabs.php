
<!--<!DOCTYPE html>
<html ng-app="app">-->
  <body ng-controller='myController'>
    <div class="tabbable tabs-left">
      <ul class="nav nav-tabs menu">
         <li ng-class="getTabClass(1)" ng-click="setActiveTab(1)"><a href="#tabCalendar" data-toggle="tab"><i class="fa fa-calendar"></i></a></li>
         <li ng-class="getTabClass(2)" ng-click="setActiveTab(2)"><a href="#tabMail" data-toggle="tab"><i class="fa fa-envelope-o"></i></a></li>
         <li ng-class="getTabClass(3)" ng-click="setActiveTab(3)"><a href="#tabWeather" data-toggle="tab"><i class="fa fa-sun-o"></i></a></li>
         <li ng-class="getTabClass(4)" ng-click="setActiveTab(4)"><a href="#tabFB" data-toggle="tab"><i class="fa fa-facebook"></i></a></li>
          <li ng-class="getTabClass(5)" ng-click="setActiveTab(5)"><a href="#tabMovies" data-toggle="tab"><i class="fa fa-film"></i></a></li>
      </ul>
      <div class="tab-content">
        <div ng-class="getTabPaneClass(1)" id="tabCalendar">   
           <?php include_once "viewCalendar.php" ?>
         </div>       
        
        <div ng-class="getTabPaneClass(2)" id="tabMail">     

            <?php include_once "viewGmail.php" ?>
        </div>
        
        <div ng-class="getTabPaneClass(3)" id="tabWeather">     
            <?php include_once "viewFacebook.php" ?>
        </div>
        
        <div ng-class="getTabPaneClass(4)" id="tabFB">     
          <h2> HELLO 4</h2>
        </div>  
        
          <div ng-class="getTabPaneClass(5)" id="tabMovies">     
            <h2> HELLO 5</h2>
        </div>  
      
      </div>
    </div>

  </body>

</html>
