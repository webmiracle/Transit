<?php
class Banner_Producer_Helper_Data extends Mage_Core_Helper_Data
{
    private $_producerAttributes = array(
        966, 1025, 1052, 1065, 1050, 1012, 978,
        1009, 1007, 1049, 990, 1045, 1038, 1019, 1088
    );

    protected $_pro  = array();
    protected $_val  = array();

    public function getProducerAttributes()
    {
        $attributeCollection = Mage::getResourceModel('eav/entity_attribute_collection')
            ->addFieldToFilter('attribute_id', array('in' => $this->_producerAttributes));

        return $attributeCollection;
    }

    public function getProducerImages()
    {
        $images = array();

        foreach ($this->getProducerAttributes() as $attribute) {
            $options = $attribute->getSource()->getAllOptions(false);
            foreach ($options as $option) {
                $indeficator = $attribute->getAttributeCode() . $option['value'];
                $producerModel = Mage::getModel('banner_producer/producer')->load($indeficator, 'option_proizv');
                if ($producerModel and $producerModel->getId() and $producerModel->getImgProizv()) {
                    $images[$option['value']]['image'] = $producerModel->getImgProizv();
                    $images[$option['value']]['label'] = $attribute->getAttributeCode();
                    $images[$option['value']]['name'] = $producerModel->getNameProizv();
                    $images[$option['value']]['desc'] = $attribute->getDescProizv();
                }
            }

        }

        return $images;
    }


    public function sad()
    {
        $n=0; $pro = array();$val = array();
        $sql="SELECT * FROM eav_attribute_option WHERE attribute_id=966
         OR attribute_id=1025 OR attribute_id=1052 OR attribute_id=1065
         OR attribute_id=1050 OR attribute_id=1012 OR attribute_id=978 OR attribute_id=1009
         OR attribute_id=1007 OR attribute_id=1049 OR attribute_id=990 OR attribute_id=1045 OR
         attribute_id=1038 OR attribute_id=1019 OR attribute_id=1088";
        $sql=mysql_query($sql);
        while($r=mysql_fetch_array($sql)){

            $option=$r['option_id'];
            $sql1="SELECT * FROM eav_attribute WHERE attribute_id=".$r['attribute_id'];
            $sql1=mysql_query($sql1);
            while($rr=mysql_fetch_array($sql1)){
                $label=$rr['attribute_code'];
            }

            $sql1="SELECT * FROM eav_attribute_option_value WHERE option_id=".$r['option_id']." AND store_id=0";
            $sql1=mysql_query($sql1);
            while($rr=mysql_fetch_array($sql1)){
                $n=$n+1;
                $pro[$n]=$rr['value'];
                $val[$n]=$label.$option;
            }
        }

        $f=0;
        while($f==0){
            $f=1;
            for($i=1;$i<$n;$i++){
                if($pro[$i]>$pro[$i+1]){

                    $s=$pro[$i];
                    $pro[$i]=$pro[$i+1];
                    $pro[$i+1]=$s;

                    $s=$val[$i];
                    $val[$i]=$val[$i+1];
                    $val[$i+1]=$s;

                    $f=0;

                }
            }
        }

        $this->_pro = $pro;
        $this->_val = $val;
    }

    public function getImageProducerHtml()
    {
        $html = '';
        for ($i = 1; $i <= count($this->_val); $i++) {
            $desc_proizv = '';
            $img_proizv = '';
            $sql = "SELECT * FROM proizv WHERE option_proizv='" . $this->_val[$i] . "'";
            $sql = mysql_query($sql);
            while ($r = mysql_fetch_array($sql)) {
                $desc_proizv = $r['desc_proizv'];
                $img_proizv = $r['img_proizv'];
            }
            $html .= "<input type='hidden' id='id_" . $this->_val[$i] . "' value='" . $desc_proizv . "'/>";
            $html .= "<input type='hidden' value='" . $img_proizv . "'/>";
            $html .= "<input type='hidden' value='" . $this->_pro[$i] . "'/>";
        }
        return $html;

    }

    public function getFirstProducerData()
    {
        $data = array();
        $sql = "SELECT * FROM proizv WHERE option_proizv='" . $this->_val[1] . "'";
        $sql = mysql_query($sql);
        while ($r = mysql_fetch_array($sql)) {
            $data['desc_proizv'] = $r['desc_proizv'];
            $data['img_proizv'] = $r['img_proizv'];
        }

        return $data;
    }


    public function getVal()
    {
        return $this->_val;
    }

    public function getPro()
    {
        return $this->_pro;
    }
}