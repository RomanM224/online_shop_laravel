@extends('layouts.main')

@section('title', 'Home')

@section('custom_css')
<link rel="stylesheet" type="text/css" href="/styles/product.css">
<link rel="stylesheet" type="text/css" href="/styles/product_responsive.css">
@endsection

@section('custom_js')
<script src="/js/product.js"></script>
<script >
	$(document).ready(function(){
		$('.cart_button').click(function(event){
			event.preventDefault();
			addToCart();
		});
	})

	function addToCart(){
		let id = $('.details_name').data('id');
		let qty = parseInt($('#quantity_input').val());
		let totalQty = parseInt($('.cart_qty').text());
		console.log(totalQty);
		totalQty +=qty;
		$('.cart_qty').text(totalQty);

		$.ajax({
			url: "{{ route('addToCart')}}",
			type: "POST",
			data:{
				id: id,
				qty: qty,
			},
			headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: (data) => {
				console.log(data);
			}			
		})
	}
</script>
@endsection

@section('content')

<div class="container">
	<div class="row details_row">

		<!-- Product Image -->
		@php
		$image = '';
		if(count($product->images) > 0){
		$image = $product->images[0]['img'];
		} else {
		$image = 'no_image.svg';
		}
		@endphp
		<div class="col-lg-6">
			<div class="details_image">
				<div class="details_image_large"><img src="/images/{{$image}}" alt="{{$product->title}}">
					<div class="product_extra product_new"><a href="categories.html">New</a></div>
				</div>
				<div class="details_image_thumbnails d-flex flex-row align-items-start justify-content-between">
					@if($image == 'no_image.svg')
					<div class="details_image_thumbnail active" data-image="/images/{{ $image }}"><img src="/images/{{ $image }}" alt="{{$product->title}}"></div>
					@else
						@foreach($product->images as $img)
							@if($loop->first)
							<div class="details_image_thumbnail active" data-image="/images/{{ $img['img'] }}"><img src="/images/{{ $img['img']}}" alt="{{$product->title}}"></div>
							@else
							<div class="details_image_thumbnail" data-image="/images/{{ $img['img'] }}"><img src="/images/{{ $img['img'] }}" alt="{{$product->title}}"></div>


							@endif
						@endforeach
					@endif
				</div>
			</div>
		</div>

		<!-- Product Content -->
		<div class="col-lg-6">
			<div class="details_content">
				<div class="details_name" data-id="{{$product->id}}">{{$product->title}}>Smart Phone</div>
				@if($product->new_price !=null)
				<div class="product_price">${{ $product->price}}</div>
				<div class="details_discount">${{ $product->new_price}}</div>
				@else
				<div class="product_price">${{ $product->price}}</div>
				@endif


				<!-- In Stock -->
				<div class="in_stock_container">
					<div class="availability">Availability:</div>
					@if($product->in_stock)
					<span>In Stock</span>
					@else
					<span style="color:red">Not In Stock</span>
					@endif
				</div>
				<div class="details_text">
					<p>{{ $product->description}}</p>
				</div>

				<!-- Product Quantity -->
				<div class="product_quantity_container">
					<div class="product_quantity clearfix">
						<span>Qty</span>
						<input id="quantity_input" type="text" pattern="[0-9]*" value="1">
						<div class="quantity_buttons">
							<div id="quantity_inc_button" class="quantity_inc quantity_control"><i class="fa fa-chevron-up" aria-hidden="true"></i></div>
							<div id="quantity_dec_button" class="quantity_dec quantity_control"><i class="fa fa-chevron-down" aria-hidden="true"></i></div>
						</div>
					</div>
					<div class="button cart_button"><a href="#">Add to cart</a></div>
				</div>

				<!-- Share -->
				<div class="details_share">
					<span>Share:</span>
					<ul>
						<li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
						<li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
						<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
						<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="row description_row">
		<div class="col">
			<div class="description_title_container">
				<div class="description_title">Description</div>
				<div class="reviews_title"><a href="#">Reviews <span>(1)</span></a></div>
			</div>
			<div class="description_text">
				<p>{{ $product->description}}</p>
			</div>
		</div>
	</div>
</div>

@endsection