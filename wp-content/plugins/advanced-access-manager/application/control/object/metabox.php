<?php/** * ====================================================================== * LICENSE: This file is subject to the terms and conditions defined in * * file 'license.txt', which is part of this source code package.       * * ====================================================================== *//** * * @package AAM * @author Vasyl Martyniuk <support@wpaam.com> * @copyright Copyright C 2013 Vasyl Martyniuk * @license GNU General Public License {@link http://www.gnu.org/licenses/} */class aam_Control_Object_Metabox extends aam_Control_Object {    /**     *     */    const UID = 'metabox';    /**     *     * @var type     */    private $_option = array();    /**     *     * @global type $wp_registered_widgets     * @param type $sidebar_widgets     * @return type     */    public function filterFrontend($sidebar_widgets) {        global $wp_registered_widgets;        if (is_array($wp_registered_widgets)) {            foreach ($wp_registered_widgets as $id => $data) {                if (is_object($data['callback'][0])) {                    $callback = get_class($data['callback'][0]);                } elseif (is_string($data['callback'][0])) {                    $callback = $data['callback'][0];                }                if ($this->has('widgets', $callback)) {                    unregister_widget($callback);                    //remove it from registered widget global var!!                    //INFORM: Why Unregister Widget does not clear global var?                    unset($wp_registered_widgets[$id]);                }            }        }        return $sidebar_widgets;    }    /**     *     * @global type $wp_meta_boxes     * @param type $screen     * @param type $post     */    public function filterBackend($screen, $post = null) {        global $wp_meta_boxes;        if (is_array($wp_meta_boxes)) {            foreach ($wp_meta_boxes as $screen_id => $zones) {                if ($screen == $screen_id) {                    foreach ($zones as $zone => $priorities) {                        foreach ($priorities as $priority => $metaboxes) {                            foreach ($metaboxes as $metabox => $data) {                                if ($this->has($screen_id, $metabox)) {                                    remove_meta_box($metabox, $screen_id, $zone);                                }                            }                        }                    }                }            }        }    }    /**     * @inheritdoc     */    public function save($metaboxes = null) {        if (is_array($metaboxes)) {            $this->getSubject()->updateOption($metaboxes, self::UID);            //set flag that this subject has custom settings            $this->getSubject()->setFlag(aam_Control_Subject::FLAG_MODIFIED);        }    }    /**     * @inheritdoc     */    public function cacheObject(){        return true;    }    /**     *     * @return type     */    public function getUID() {        return self::UID;    }    /**     *     * @param type $option     */    public function setOption($option) {        $this->_option = (is_array($option) ? $option : array());    }    /**     *     * @return type     */    public function getOption() {        return $this->_option;    }    /**     *     * @param type $group     * @param type $metabox     * @return type     */    public function has($group, $metabox) {        $response = false;        if (isset($this->_option[$group][$metabox])) {            $response = (intval($this->_option[$group][$metabox]) ? true : false);        }        return $response;    }}