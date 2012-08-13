<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<?php foreach($this->items as $i => $item):
	$ordering	= ($this->listOrder == 'ordering');
?>
	<tr class="row<?php echo $i % 2; ?>">
		<td class="center">
			<?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
		<td class="center">
			<?php echo JHtml::_('jgrid.published', $item->published, $i, 'gifts.');?>
		</td>
		<td>
			<a href="<?php echo JRoute::_('index.php?option=com_dnagifts&task=gift.edit&id='.(int) $item->id); ?>"><?php echo $this->escape($item->code); ?></a>
		</td>
		<td>
			<a href="<?php echo JRoute::_('index.php?option=com_dnagifts&task=gift.edit&id='.(int) $item->id); ?>"><?php echo $this->escape($item->name); ?></a>
		</td>
		<td>
			<?php echo $item->description; ?>
		</td>
		<td>
			<?php echo $item->color_hex; ?> <div class="colorpatch" style="background-color: <?php echo $item->color_hex; ?>"></div>
		</td>
		<td class="center">
			<?php echo $item->language; ?>
		</td>
		<td class="center">
			<?php echo JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC2')); ?>
		</td>
		
		<td class="order">
			<?php if ($this->saveOrder) :?>
				<?php if ($this->listDirn == 'asc') : ?>
					<span><?php echo $this->pagination->orderUpIcon($i, true, 'gifts.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
					<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'gifts.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
				<?php elseif ($this->listDirn == 'desc') : ?>
					<span><?php echo $this->pagination->orderUpIcon($i, true, 'gifts.orderdown', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
					<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'gifts.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
				<?php endif; ?>
			<?php endif; ?>
			<?php $disabled = $this->saveOrder ?  '' : 'disabled="disabled"'; ?>
			<input type="text" name="order[]" size="5" value="<?php echo $item->ordering;?>" <?php echo $disabled ?> class="text-area-order" />
		</td>
		
		<td class="center">
			<?php echo (int) $item->id; ?>
		</td>
	</tr>
<?php endforeach; ?>