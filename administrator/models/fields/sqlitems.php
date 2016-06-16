<?php
/**
 * @version     1.0.0
 * @package     com_catcomplects
 * @copyright   © 2015. Demin Artem. Все права защищены.
 * @license     GNU General Public License версии 2 или более поздней; Смотрите LICENSE.txt
 * @author      Demin Artem <ademin1982@gmail.com> - http://
 */

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');

//JFormHelper::loadFieldClass('list');

/**
 * Supports an HTML select list of categories
 */
class JFormFieldSqlitems extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'sqlitems';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
	        // Initialize variables. 
         $html = array(); 
         $html[] = '<select id="'.$this->id.'" name="'.$this->name.'[]" multiple="multiple" class="'.$this->class.'">'; 
  
         // do the SQL
         $db = JFactory::getDbo();
         $query = $db->getQuery(true);
         $query 
           ->select('*')
           ->from($db->quoteName('#__catcomplects_items'))
           ->where($db->quoteName('state').'=1')
           ->order($db->quoteName('catid').','.$db->quoteName('name').','.$db->quoteName('price'));
         $db->setQuery($query);
         $rows = $db->loadObjectList(); 
  
         // iterate through returned rows 
         foreach( $rows as $row ){ 
             $html[] = '<option value="'.$row->article.'">'.$row->name.' ('.$row->height.'х'.$row->width.' мм.) - '.$row->price.' р.</option>';
             // $html[] = '<option value="'.$row->article.'">'.$row->name.'</option>';
         } 
         $html[] = '</select>'; 

         return implode($html);
         
		// Initialize variables.
		//$html = array();
    /*
		return '<select id="'.$this->id.'" name="'.$this->name.'">'.
		       '<option value="1" >New York</option>'.
		       '<option value="2" >Chicago</option>'.
		       '<option value="3" >San Francisco</option>'.
		       '</select>'; 
		*/
		// return implode($html);
	}
}