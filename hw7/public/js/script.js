function getData(id) {
    jQuery.ajax({
        method: 'post',
        url: '/cart/fakeAdd?id=' + id,
        success: function (response) {
            console.log(response);
        }
    });
}