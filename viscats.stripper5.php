<?php


if (!class_exists('strip_attributes')) {

	/**
	* Strip attribute Class
	* Remove attributes from XML elements
	* @author David (semlabs.co.uk)
	* @version 0.2
	*/
	
	function reg_escape($str) {
		$conversions = array("^" => "\^", "[" => "\[", "." => "\.", "$" => "\$", "{" => "\{", "*" => "\*", "(" => "\(", "\\" => "\\\\", "/" => "\/", "+" => "\+", ")" => "\)", "|" => "\|", "?" => "\?", "<" => "\<", ">" => "\>");
		return strtr($str, $conversions);
	}
	
	class strip_attributes {
		
		const STRIP_COMMENTS = 1;
		const STRIP_ALL_COMMENTS = 2;
		
		protected $str		= '';
		public $allow		= array();
		public $exceptions	= array();
		public $ignore		= array();
		
		public function strip($str) {
			$this->str = $str;
			
			if(is_string($str) && strlen($str) > 0) {
				$res = $this->find_elements();
				if(is_string($res))
					return $res;
				$nodes = $this->find_attributes($res);
				$this->remove_attributes($nodes);
			}
			
			return $this->str;
		}
		
		private function find_elements() {
			
			# Create an array of elements with attributes
			$nodes = array();
			preg_match_all("/<([^ !\/\>]+)([^>]*)>/i", $this->str, $elements);
			foreach($elements[1] as $el_key => $element) {
				if($elements[2][$el_key]) {
					$literal = $elements[0][$el_key];
					$element_name = $elements[1][$el_key];
					$attributes = $elements[2][$el_key];
					if(is_array($this->ignore) && !in_array($element_name, $this->ignore))
						$nodes[] = array('literal' => $literal, 'name' => $element_name, 'attributes' => $attributes);
				}
			}
			
			# Return the XML if there were no attributes to remove

			if(count($nodes) > 0)
				return $nodes;
			else
				return $this->str;
		}
		
		private function find_attributes($nodes) {
			
			# Extract attributes
			foreach($nodes as &$node) {
				preg_match_all("/([^ =]+)\s*=\s*[\"|']{0,1}([^\"']*)[\"|']{0,1}/i", $node['attributes'], $attributes);
				#print_r($attributes[1]);
				if($attributes[1]) {
					foreach($attributes[1] as $att_key => $att) {
						$literal = $attributes[0][$att_key];
						$attribute_name = $attributes[1][$att_key];
						$value = $attributes[2][$att_key];
						$atts[] = array('literal' => $literal, 'name' => $attribute_name, 'value' => $value);
					}
				}
				else
					$node['attributes'] = null;
				
				$node['attributes'] = $atts;
				unset($atts);
			}
			
			return $nodes;
		}
		
		private function remove_attributes($nodes) {
			
			# Remove unwanted attributes
			foreach($nodes as $node) {
				
				# Check if node has any attributes to be kept
				$node_name = $node['name'];
				$new_attributes = '';
				if(is_array($node['attributes'])) {
					foreach($node['attributes'] as $attribute) {
						if((is_array($this->allow) && in_array($attribute['name'], $this->allow)) || $this->is_exception($node_name, $attribute['name'], $this->exceptions))
							$new_attributes = $this->create_attributes($new_attributes, $attribute['name'], $attribute['value']);
					}
				}
				$replacement = ($new_attributes) ? "<$node_name $new_attributes>" : "<$node_name>";
				$this->str = preg_replace('/'. reg_escape($node['literal']) .'/', $replacement, $this->str);
			}
			
		}
		
		private function is_exception($element_name, $attribute_name, $exceptions) {
			if(array_key_exists($element_name, $this->exceptions)) {
				if(in_array($attribute_name, $this->exceptions[$element_name]))
					return true;
			}
			
			return false;
		}
		
		private function create_attributes($new_attributes, $name, $value) {
			if($new_attributes)
				$new_attributes .= " ";
			$new_attributes .= "$name=\"$value\"";
			
			return $new_attributes;
		}
	
	}

}
	
?>
