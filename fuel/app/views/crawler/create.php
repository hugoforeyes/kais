<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Kais</title>
	<?php echo Asset::css('bootstrap.css'); ?>
	<?php echo Asset::css('style.css'); ?>
	<?php echo Asset::js('jquery.min.js'); ?>
	<?php echo Asset::js('jquery.loading.js'); ?>
</head>
<body>
	<br/>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-1">
				<a class="btn btn-info" href="<?php echo Uri::create('crawler/') ?>">Back</a>
			</div>
			<div class="col-md-6">
				<form method="POST">
					<span style="display: inline-block;">URL: </span>
					<input type="text" name="url" class="form-control" id="url" value="<?php echo $url; ?>" style="display: inline-block; width: 80%;" />
					<button class="btn btn-default" style="display: inline-block;">Submit</button>
				</form>
			</div>
		</div>
		<br/><br/>
		<div class="row">
			<div class="col-md-8">
				<div class="website" id="hugo_mark">
					<?php echo html_entity_decode($website); ?>
				</div>
			</div>
			<div class="col-md-4">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<div class="row" id="ele_0">
								<div class="col-md-1"><input type="radio" name="property-group" class="rbtn-attr" value="0" onclick="select_property(0)" id="cb_object" checked/></div>
								<div class="col-md-3"><input class="form-control" id="pp_name_0" placeholder="Name" value="<?php echo $is_edit ? $crawler['object_name'] : ''; ?>"/></div>
								<div class="col-md-5"><input class="form-control" id="pp_selector_0" placeholder="Selector" value="<?php echo $is_edit ? $crawler['selector_text'] : ''; ?>"/></div>
								<div class="col-md-3">
									<button class="btn btn-default" onclick="create_property_row();">+</button>
									<button class="btn btn-warning pull-right" onclick="submit_data();">Submit</button>
								</div>
							</div>
						</div>
						<div class="panel-body" id="property-wrapper">
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">List elements</h3>
						</div>
						<div class="panel-body" id="div_ele">
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Info</h3>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<label>Name</label>
								<input type="text" class="form-control" placeholder="Name" id="crawler_name" value="<?php echo $is_edit ? $crawler['crawler_name'] : ''; ?>">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<form method="POST" action="<?php echo Uri::create('crawler/save').($is_edit ? '/'.$id : '') ?>" id="form-save">
		<input type="hidden"  name="crawler_data" id="crawler_data"/>
	</form>
</body>

<script type="text/javascript">
var list_elements = {};
var data_selector = {};


/**********************
 SECTION VIEW WEBSITE
 ***********************/
$(document).ready(function () {
	$('.website *').on("click", "*", function(e) {
		e.stopPropagation();
		//Reset data
		data_selector[current_property] = null;
		list_elements[current_property] = null;
		$("#pp_selector_"+current_property).val("");
		render_elements();


		var container_element = (current_property != 0 && data_selector[0]) ? get_last_selector(data_selector[0]) : null;
		list_elements[current_property] = create_list_tag($(this), container_element);
		render_elements();
	});

	<?php if($is_edit) { ?>
		var list_property = JSON.parse('<?php echo str_replace(array("\\n","\\r"),"",html_entity_decode(json_encode($crawler['property'], JSON_UNESCAPED_UNICODE))); ?>');
		console.log(list_property)
		for (var i in list_property) {
			create_property_row();
			$("#pp_name_" + (parseInt(i) + 1)).val(list_property[i].name);
			$("#pp_selector_" + (parseInt(i) + 1)).val(list_property[i].selector_text);
		}
	<?php } ?>
});

function get_last_selector(data_selector) {
	var temp;
	for(var i in data_selector)
		temp = data_selector[i];
	return temp;
}

function create_list_tag($element, container_element) {
	if ( ! $element)
		return [];
	if($element[0].className == "website" && $element[0].id == "hugo_mark")
		return [];
	if($element[0].tagName == "BODY")
		return [];
	if(is_container_element(container_element, $element))
		return [];
	return create_list_tag($element.parent(), container_element).concat([$element]);
}

function is_container_element(container_element, $ele) {
	if ( ! container_element || ! $ele)
		return false;
	if ($ele[0].tagName != container_element.$$tag)
		return false;
	for(var field in container_element) {
		if(field == '$$tag' || field == '$$ele_index' || field == '$$order')
			continue;
		if( ! $ele[0].attributes[field])
			return false;
		if($ele[0].attributes[field].value != container_element[field])
			return false;
	}
	return true;
}

function generate_seletor($element)
{
	var selector = $element.tagName.toLowerCase();
	if($element.className)
		selector += "."+$element.className.split(" ").join(".");
	if($element.id)
		selector += "#"+$element.id;
	return selector;
}

function generate_selector_on_list(index, current_index)
{
	if ( ! current_index)
		current_index = 0;
	if (current_index > index)
		return '';
	if (current_index == index)
		return generate_seletor(list_elements[current_property][current_index][0]);
	return generate_seletor(list_elements[current_property][current_index][0]) + " " + generate_selector_on_list(index, (current_index + 1));
}

function identify_on_view(index)
{
	reset_view();
	var container_selector = "";
	if (current_property)
		container_selector = generate_selector_text(data_selector[0]);

	var select_text = container_selector + " " + generate_selector_on_list(index);
	console.log(select_text);
	$(select_text).loading();
}

function reset_view()
{
	$(".js-loading").removeClass("js-loading");
	$(".js-loading-overlay").remove();
}

function show_hide_detail_item(i)
{
	$("#item_"+i).toggle();
}

/*****************
 SECTION ELEMENT
 *****************/
function render_elements()
{
	var data = list_elements[current_property];
	$("#div_ele").empty();
	var html;
	for (var i in data) {
		html = '<div class="well well-sm" onmouseenter="identify_on_view('+i+')" onmouseleave="reset_view()" onclick="show_hide_detail_item('+i+')">';
		html += '<input type="checkbox" id="view_ele_'+i+'" onclick="event.stopPropagation(); select_element(this, '+i+', \''+data[i][0].tagName+'\');"/> <span>' + generate_seletor(data[i][0]) + '</span>';
		html += '<div class="detail_element" id="item_'+i+'" style="display: none;"><ul>';
		for (var j = 0; j < data[i][0].attributes.length; j++) {
			html += '<li><input type="checkbox" id="view_ele_attr_'+data[i][0].attributes[j].nodeName+'" onclick="event.stopPropagation(); select_attr(this, '+i+',\''+data[i][0].attributes[j].nodeName+'\', \''+data[i][0].attributes[j].nodeValue+'\');"/> <b>' + data[i][0].attributes[j].nodeName + ': </b><span>'+data[i][0].attributes[j].nodeValue+'</span></li>';
		}
		html += '</ul>';
		html += '<div class="seperate-attr">';
		html += '<input type="number" onclick="event.stopPropagation();" style="width: 60px;" id="view_ele_order_'+i+'" placeholder="order" onchange="change_element_order(this, '+i+')"/>';
		html += '</div>';
		html += '</div></div>';
		$("#div_ele").append(html);
	}
}

function select_element($ele, element_index, name)
{
	if(typeof current_property === 'undefined')
		return reset_checkbox();

	if( ! data_selector[current_property])
		data_selector[current_property] = {};

	if( ! $ele.checked) {
		$($ele).parent().find('input').prop('checked', false);
		delete data_selector[current_property][element_index];
	} else {
		if( ! data_selector[current_property][element_index])
			data_selector[current_property][element_index] = {'$$ele_index': element_index};
		data_selector[current_property][element_index]['$$tag'] = list_elements[current_property][element_index][0].tagName;
		//Set order value again
		data_selector[current_property][element_index]['$$order'] = $("#view_ele_order_"+element_index).val();
	}
	$("#pp_selector_"+current_property).val(generate_selector_text(data_selector[current_property]));
	generate_option_value();
}

function select_attr($ele, element_index, attr, value)
{
	if(typeof current_property === 'undefined')
		return reset_checkbox();

	if( ! data_selector[current_property])
		data_selector[current_property] = {};

	if($ele.checked) {
		$("#view_ele_"+element_index).prop('checked', true);
		if( ! data_selector[current_property][element_index])
			data_selector[current_property][element_index] = {'$$ele_index': element_index};
		data_selector[current_property][element_index][attr] = value;
		data_selector[current_property][element_index]['$$tag'] = list_elements[current_property][element_index][0].tagName;

		//Set order value again
		data_selector[current_property][element_index]['$$order'] = $("#view_ele_order_"+element_index).val();
	} else if(data_selector[current_property][element_index]) {
		delete data_selector[current_property][element_index][attr];
	}
	$("#pp_selector_"+current_property).val(generate_selector_text(data_selector[current_property]));
	generate_option_value();
}

function change_element_order($ele, element_index)
{
	if(typeof current_property === 'undefined')
		return;

	if( ! data_selector[current_property])
		data_selector[current_property] = {};

	if ( ! data_selector[current_property][element_index])
		return;

	var ele_order = $($ele).val();
	data_selector[current_property][element_index]['$$order'] = (ele_order ? ele_order : "");
}

function reset_checkbox() {
	$("input[type='checkbox']").prop('checked', false);
}

function apply_selector(property_index) {
	if( ! property_index)
		property_index = current_property;
	if( ! data_selector[property_index])
		return;
	if($.isEmptyObject(data_selector[property_index]))
		return;
	for(var element_index in data_selector[property_index]) {
		var data_ele = data_selector[property_index][element_index];
		$("#view_ele_" + element_index).prop('checked', true);
		for(var attr in data_ele) {
			if(attr == '$$tag' || attr == '$$ele_index' || attr == '$$order')
				continue;
			$("#view_ele_attr_" + attr).prop('checked', true);
		}
	}
}



/*****************
 SECTION PROPERTY
 *****************/
var current_property = 0;
var property_count = 1;
function create_property_row()
{
	var index = property_count++;
	current_property = index;
	var html = '<div class="row property" id="ele_'+index+'">';
	html += '<div class="col-md-1"><input type="radio" name="property-group" class="rbtn-attr" value="'+index+'" checked onclick="select_property('+index+')"/></div>';
	html += '<div class="col-md-3"><input class="form-control" id="pp_name_'+index+'" placeholder="Name" /></div>';
	html += '<div class="col-md-4"><input class="form-control" id="pp_selector_'+index+'" placeholder="Selector" /></div>';
	html += '<div class="col-md-2">';
	html += '<select class="form-control" id="pp_value_'+index+'">'
	html += '<option value="$$text">Text</option>';
	html += '</select>';
	html += '</div>';
	html += '<div class="col-md-2"><button class="btn btn-default" onclick="delete_property_row('+index+')">-</button></div>';
	html += '</div>';
	$("#property-wrapper").append(html);
	render_elements();
	reset_checkbox();
}

function delete_property_row(property_index)
{
	$("#ele_"+property_index).remove();
	delete list_elements[property_index];
	delete data_selector[property_index];
	if(property_index != current_property)
		return;

	$("#cb_object").prop('checked', true);
	select_property(0);
}

//When checkbox click
function select_property(property_index)
{
	current_property = property_index;
	render_elements();
	reset_checkbox();
	apply_selector();
}

function generate_selector_text(data_selector)
{
	var result = '';
	for(var i in data_selector) {
		result += data_selector[i].$$tag;
		for (var attr in data_selector[i]) {
			switch(attr) {
				case '$$tag': break;
				case '$$ele_index': break;
				case '$$order': break;
				case 'class': result += '.'+data_selector[i][attr].trim().replace(/\s+/g,"."); break;
				case 'id': result += '#'+data_selector[i][attr]; break;
				default:
					result += '['+attr+'="'+data_selector[i][attr]+'"]';
			}
		}
		result += ' ';
	}
	return result;
}

function generate_option_value()
{
	var selector = get_last_selector(data_selector[current_property])
	var attributes_data = list_elements[current_property][selector.$$ele_index][0].attributes;
	var html = "<option value='$$text'>Text</option>";
	for (var j = 0; j < attributes_data.length; j++) {
		html += "<option value='"+attributes_data[j].nodeName+"'>"+attributes_data[j].nodeName+"</options>";
	}
	$("#pp_value_"+current_property).html(html);
}

/****************
 * SECTION OTHER
 ****************/

function submit_data()
{
	var post_data = {};
	post_data.website = $("#url").val();
	post_data.object_name = $("#pp_name_0").val();
	post_data.data_selector = data_selector[0];
	post_data.selector_text = $("#pp_selector_0").val();
	post_data.crawler_name = $("#crawler_name").val();
	post_data.property = [];
	var pp_data;
	for(var pp_index in data_selector) {
		if(pp_index == 0)
			continue;
		pp_data = {};
		pp_data.name = $("#pp_name_"+pp_index).val();
		pp_data.value_field = $("#pp_value_"+pp_index).val();
		pp_data.data_selector = data_selector[pp_index];
		pp_data.selector_text = $("#pp_selector_"+pp_index).val();
		post_data.property.push(pp_data);
	}
	$("#crawler_data").val(JSON.stringify(post_data));
	$("#form-save").submit();
}

</script>

</html>
