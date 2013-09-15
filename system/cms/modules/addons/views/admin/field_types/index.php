<section class="title">
	<h4>{{ helper:lang line="global:field_types" }}</h4>
</section>

<section class="item">
<div class="content">

<h2>{{ helper:lang line="addons:plugins:core_field_types" }}</h2>

<?php if ($core): ?>
<table class="table-list" cellspacing="0">
	<thead>
		<tr>
			<th>{{ helper:lang line="name_label" }}</th>
			<th>{{ helper:lang line="version_label" }}</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($core as $c_ft): ?>
	<tr>
		<td width="60%"><?php echo $c_ft['name'] ?>
		<td><?php echo $c_ft['version'] ?>
	</tr>
	<?php endforeach ?>
	</tbody>
</table>
<?php endif ?>

<h2>{{ helper:lang line="addons:plugins:add_on_field_types" }}</h2>

<?php if ( ! empty($addon)): ?>
<table class="table-list" cellspacing="0">
	<thead>
		<tr>
            <th>{{ helper:lang line="name_label" }}</th>
            <th>{{ helper:lang line="version_label" }}</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($addon as $a_ft): ?>
	<tr>
		<td width="60%"><?php echo $a_ft['name'] ?>
		<td><?php echo $a_ft['version'] ?>
	</tr>
	<?php endforeach ?>
	</tbody>
</table>
<?php endif ?>

</div>
</section>
