    <div class="container">
        <div class="starter-template">
            <br/> <br/>
            <div class="row">
                    Posts: {{posts}} <button type="button" class="btn btn-primary btn-lg" ng-click="export()">Export</button> Views: {{views}}
                    <br/> <br/>
            </div>
            <div class="row">
                <form class="form-inline">
                <div class="form-group">
                    <input type="text" class="form-control" ng-model="title" id="title"  name="title" placeholder="Image title" >
                    <input type="file" class="form-control" file-model="imageFile">
                    <button ng-click="upload()" class="btn btn-primary btn-lg">Upload image</button>
                </div>
                </form>
                {{image_status}}
            </div>
            <br/><br/>
            <div ng-repeat="image in listImages">
                <div class="row">
                    <p>{{image.title}}</p>
                    <img src="images/{{image.name}}" width="300" height="250"/>
                    <br/>
                    <br/>
                </div>
            </div>
        </div>
    </div><!-- /.container -->


