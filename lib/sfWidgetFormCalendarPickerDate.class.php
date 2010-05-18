<?php
/**
 * Class sfWidgetFormCalendarPickerDateclass
 *
 * This class implements the really nice calendarPicker plugin for jQuery framework.
 * Look at here for an example: http://bugsvoice.com/applications/bugsVoice/site/test/calendarPickerDemo.jsp
 * Be sure to have jquery enabled on the page where the widget is displayed
 *
 * @author Matteo Giachino
 */


class sfWidgetFormCalendarPickerDate extends sfWidgetForm
{
  protected function configure($options = array(), $attributes = array())
  {
    $this->addOption('type', 'hidden');
    $this->addOption('today_button', null);
    $this->addOption('width', 280);
    $this->addOption('day_names', array());
    $this->addOption('month_names', array());
    $this->addOption('years', 1);
    $this->addOption('months', 3);
    $this->addOption('days', 5);
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $fieldId = $this->generateId($name);
    $htmlContent = '<div id="' . $fieldId . '_picker" style="width:' . $this->getOption('width') . 'px"></div>';

    $jsContent = "<script type=\"text/javascript\">\n";
    $jsContent .= "var calPick_" . $fieldId . " = $('#" . $fieldId . "_picker').calendarPicker({";
    $jsContent .= "callbackDelay:0,\n";
    $jsContent .= "callback:function(cal) { var dateObj = new Date(cal.currentDate); $('#" . $fieldId . "').val(convertDateToString(dateObj)); }, \n";
    $jsContent .= $this->getOption('month_names') != array() ? $this->generateMonthNames($this->getOption('month_names'))."\n" : '';
    $jsContent .= $this->getOption('day_names') != array() ? $this->generateDayNames($this->getOption('day_names'))."\n" : '';
    $jsContent .= "useWheel:true,\n";
    $jsContent .= "years:" . $this->getOption('years') . ",\n";
    $jsContent .= "months:" . $this->getOption('months') . ",\n";
    $jsContent .= "days:" . $this->getOption('days') . ",\n";
    $jsContent .= "});\n";
    
    if (null !== $this->getOption('today_button')) {
      $jsContent .= "function goToToday() { $('#" . $fieldId . "').changeDate(new Date()); }\n";
      $htmlContent .= '<a href="javascript:void(0)" onclick="calPick_' . $fieldId . '.changeDate(new Date())" id="' . $fieldId . '_today">' . $this->getOption('today_button') . '</a>';
    }
    if ($value != null) $jsContent .= 'setCurrentDate(calPick_' . $fieldId . ', \'' . $value . '\')'."\n";
    $jsContent .= '</script>';
    
    return $this->renderTag('input', array_merge(array('type' => $this->getOption('type'), 'name' => $name, 'value' => $value), $attributes)) . $htmlContent . $jsContent;
  }

  private function generateMonthNames($months) {
      $out = 'monthNames:[';
      for ($i = 0; $i < 12; $i++) {
          $out .= '"'.$months[$i].'"';
          $out .= $i == 11 ? '' : ', ';
      }
      $out .= '],';
      return $out;
  }
  private function generateDayNames($days) {
      $out = 'dayNames:[';
      for ($i = 0; $i < 7; $i++) {
          $out .= '"'.$days[$i].'"';
          $out .= $i == 6 ? '' : ', ';
      }
      $out .= '],';
      return $out;
  }

  public function getStylesheets()
  {
    return array(
      '/sfWidgetCalendarPickerDatePlugin/css/jquery.calendarPicker.css' => 'screen'
    );
  }

  public function getJavascripts()
  {
    return array(
      '/sfWidgetCalendarPickerDatePlugin/js/jquery.calendarPicker.js',
      '/sfWidgetCalendarPickerDatePlugin/js/jquery.mousewheel.js',
      '/sfWidgetCalendarPickerDatePlugin/js/functions.js',
    );
  }
}