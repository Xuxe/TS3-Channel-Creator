<?PHP include('config.php'); ?>
<!DOCTYPE html>
  <html ng-app="chadd">
    <head>
      <title>Channelcreator V2</title>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">
      <!--Let browser know website is optimized for mobile-->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <meta name="author" content="Julian Hübenthal (julian-huebenthal.de)">
      <meta name="description" content="">
      <style>
      #preloader {
        position: fixed; 
        left: 0; 
        top: 0; 
        z-index: 999; 
        width: 100%; 
        height: 100%; 
        overflow: visible; 
        background: #fff !important;
        margin: auto !important;

      }
      .preload-center {
         display: table;
         vertical-align: middle;
         margin: auto;
         top: 50%;
      }
      </style>
      <div id="preloader">
        <center><h3>Loading...</h3></center>
          <div class="preloader-wrapper preload-center big active">
            <div class="spinner-layer spinner-red-only">
              <div class="circle-clipper left">
                <div class="circle"></div>
              </div><div class="gap-patch">
                <div class="circle"></div>
              </div><div class="circle-clipper right">
                <div class="circle"></div>
              </div>
            </div>
          </div>
      </div>
    </head>

    <body>
    <nav class="red darken-4" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo">Channelcreator V2</a>
      <ul class="right hide-on-med-and-down">
        <li><a href="/">Home</a></li>
      </ul>
      <ul id="nav-mobile" class="side-nav">
        <li><a href="/">Home</a></li>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
  </nav>
  
  <div class="container">
    <div id="chadd" style="min-height: 600px; padding: 40px;" ng-controller="chadd">
         <div class="row">
              <div class="row">
                <div class="col s12 m6">
                  <div class="card blue-grey darken-1" style="vertical-align: middle;">
                    <div id="response" class="card-content white-text">
                      <span class="card-title">{{RESPONSE_HEADER_MSG}}</span>
                      <p>{{RESPONSE_MSG}}</p>
                    </div>
                     <div ng-if="hasConnURL" ng-init="hasConnURL=false" class="card-action">
                        <a href="{{CONN_URL}}">Connect</a>
                     </div>
                  </div>
                </div>
          </div>

              <form ng-submit="submit()" class="col s12">
                <div class="row">
                <div class="input-field col s12">
                 <input ng-value="UUID" id="UUID" length="28" ng-model="UUID" name="UUID" type="text" class="validate" ng-disabled="aa" ng-init="aa-false" required>
                 <label for="UUID">UUID</label>
                </div>
              </div>

                  <div class="input-field col s6">
                    <input ng-model="cname" length="40" name="cname" type="text" class="validate" required>
                    <label for="cname">Channel Name</label>
                  </div>
                  <div class="input-field col s6">
                    <input id="password" length="40" ng-model="password" name="password" type="password" class="validate" required>
                    <label for="password">Password</label>
                  </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                    <select ng-model="codec" id="codec" name="codec" required>
                      <option value="" disabled selected>Choose your option</option>
                      <option value="1">Opus Voice</option>
                      <option value="2">Celt-Mono</option>
                      <option value="3">Speex-Ultra</option>
                    </select>
                    <label>Channel Codec</label>
                   </div>
                </div>
                <div class="row">
                  <div class="input-field col s12">
                            <p class="range-field">
                            <input type="range" id="quality" ng-model="quality" name="quality" min="0" max="10" required>
                            </p>
                            <label>Codec Quality</label>
                  </div>
                </div>
                <div class="row">
                  <div class="input-field col s12">
                  <div class="g-recaptcha" data-sitekey="<?PHP echo $public; ?>"></div>
                  </div>
                </div>
                <button type="submit" id="submit" class="waves-effect waves-light btn-large"><i class="material-icons right">send</i>Create</button>
              </form>
            </div>
      </div>
  </div>


    <footer class="page-footer red darken-4">
          <div class="container">
            <div class="row">
              <div class="col l6 s12">
                <h5 class="white-text">Footer ;)</h5>
                <ul class="icons">
                </ul>
              </div>
              <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Links</h5>
                <ul>
                  <li><a class="grey-text text-lighten-3" href="<?PHP echo $imprint_url; ?>">Impressum</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container">
            &copy; 2016 by <a class="grey-text text-lighten-3" href="http://julian-huebenthal.de">Xuxe</a>
            <a class="grey-text text-lighten-4 right" href="#top"><i class="fa fa-2x fa-arrow-up"></i></a>
            </div>
          </div>
      </footer>
      <script src='https://www.google.com/recaptcha/api.js'></script>
      <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
      <script src="js/angular.min.js"></script>
      <script src="js/main.js"></script>
  </body>

</html>