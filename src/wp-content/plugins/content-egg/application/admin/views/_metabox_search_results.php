<div class="search_results" ng-show="models.<?php echo $module_id; ?>.results.length > 0 && !models.<?php echo $module_id; ?>.processing && !models.<?php echo $module_id; ?>.error">
    <div class="row search_results_row" ng-class="{'result_added' : result.added}" ng-click="add(result, '<?php echo $module_id; ?>')" repeat-done ng-repeat="result in models.<?php echo $module_id; ?>.results">
        <div class="col-md-1" ng-if="result.img">
            <img ng-src="{{result.img}}" class="img-thumbnail" />
        </div>
        <div ng-class="result.img ? 'col-md-11' : 'col-md-12'">
            <strong ng-show="result.title">{{result.title}}</strong>
            <p ng-show="result.description">{{result.description| limitTo: 200}}{{result.description.length > 200 ? '&hellip;' : ''}}</p>
            <p>
                <span ng-show="result.price">{{result.currencyCode}} <strike ng-show="result.priceOld">{{result.priceOld}}</strike> {{result.price}}</span>
                <span ng-show="result.domain" class="text-muted">&nbsp;&nbsp;<img src="http://www.google.com/s2/favicons?domain={{result.domain}}"> {{result.domain}}</span>
                &nbsp;&nbsp;<small class="text-muted" ng-show="result.ean"><?php _e('EAN:'); ?> {{result.ean}}</small>
            </p>
            <div ng-show="result.code">
                <?php _e('Coupon code:', 'content-egg'); ?> <em>{{result.code}}</em>
                - <span ng-show="result.startDate">{{result.startDate * 1000|date:'mediumDate'}} - {{result.endDate * 1000|date:'mediumDate'}}</span>
            </div>
        </div>
    </div>
</div>