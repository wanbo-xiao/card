<div>
    <table class="table table-striped">
        <tbody>
            <tr style="height: 75px" ng-repeat="twitter in twitters">
                <td style="width: 100px">
                    <img ng-src="{{twitter.image}}"/>
                </td>
                <td>{{twitter.screen_name}}</td>
                <td>{{twitter.created_at}}</td>
                <td>{{twitter.text}}</td>
            </tr>
        </tbody>
    </table>
</div>