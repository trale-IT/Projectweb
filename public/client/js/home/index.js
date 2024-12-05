
//Lây tất cả sản phẩm mới
function fetchNewProducts() {
    
    $.ajax({
        url: 'fetchNewProducts',
        method: 'GET',
        success: function(response) {
            console.log(response);
            setDataNewProducts(response.products);
        },
        error: function(xhr, status, error) {
            // Xử lý lỗi
        }
    });
}
function setData(){
    $('#new-products').empty();
    $('#new-products').append(`
    <div class="product">
    <div class="product-img">
        <img src="{{asset('client/img/product01.png')}}" alt="">
        <div class="product-label">
            <span class="sale">-1%</span>
            <span class="new">NEW</span>
        </div>
    </div>
    <div class="product-body">
        <p class="product-category">Category</p>
        <h3 class="product-name"><a href="#">product name goes here 1</a></h3>
        <h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>
        <div class="product-rating">
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
        </div>
        <div class="product-btns">
            <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>
            <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>
            <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
        </div>
    </div>
    <div class="add-to-cart">
        <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>
    </div>
</div>
`);
}



