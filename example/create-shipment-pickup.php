<?php
// TODO: write docs
if (!file_exists('env.php')) {
  copy('sample.env.php', 'env.php');
}
require('env.php');

require '../vendor/autoload.php';

use \Mijora\Itella\Shipment\Party;
use \Mijora\Itella\Shipment\GoodsItem;
use \Mijora\Itella\Shipment\Shipment;
use \Mijora\Itella\Shipment\AdditionalService;
use \Mijora\Itella\Helper;

try {

  // Create and configure sender
  $sender = new Party(Party::ROLE_SENDER);
  $sender
    ->setContract(${'contract_' . Shipment::PRODUCT_PICKUP}) // important, given by itella
    ->setName1('TEST Web Shop')
    ->setStreet1('Shop str. 150')
    ->setPostCode('47174')
    ->setCity('Kaunas')
    ->setCountryCode('LT')
    ->setContactMobile('+37060000000')
    ->setContactEmail('sender@test.lt');

  // Create and configure receiver
  $receiver = new Party(Party::ROLE_RECEIVER);
  $receiver
    ->setName1('Test Tester')
    ->setStreet1("test str. 6")
    ->setPostCode("10011")
    ->setCity("vilnius")
    ->setCountryCode('lt')
    ->setContactName('Mike')
    ->setContactMobile('860000000')
    ->setContactEmail('receiver@test.lt')
    ;

  // Create GoodsItem (parcel)
  $item = new GoodsItem();
  $item
    ->setGrossWeight(2) // kg
    ->setVolume(0.1); // m3

  // Create additional services
  $service_cod = new AdditionalService(3101, array(
    'amount' => 100,
    'account' => 'LT100000000000',
    'reference' => Helper::generateCODReference('666'),
    'codbic' => 'XBC0101'
  ));

  // Create shipment object
  $shipment = new Shipment($p_user, $p_secret);
  $shipment
    ->setProductCode(Shipment::PRODUCT_PICKUP) // should always be set first
    ->setShipmentNumber('Test_ORDER_pickup') // shipment number 
    //->setShipmentDateTime(date('c')) // when package will be ready (just use current time)
    ->setSenderParty($sender) // Sender class object
    ->setReceiverParty($receiver) // Receiver class object
    ->setPickupPoint("621353201")
    ->addAdditionalService($service_cod)
    ->addGoodsItem($item) // GoodsItem class object (or in case of multiparcel can be array of GoodsItem)
    ->setComment('Comment for pickup label')
  ;

  $xml = false;

  if ($xml) {
    $result = $shipment->asXML();
    echo "<br>XML REQUEST<br>\n";
    echo "<br>Shipment sent:<br>\n<code>" . $result . "</code>\n";
  } else {
    $result = $shipment->registerShipment();
    echo "<br>Shipment registered:<br>\n<code>" . $result . "</code>\n";
    file_put_contents(dirname(__FILE__) . '/../temp/registered_tracks.log', "\n" . $result, FILE_APPEND);
  }
} catch (\Exception $th) {
  echo "\n<br>Exception:<br>\n"
    . str_replace("\n", "<br>\n", $th->getMessage()) . "<br>\n"
    . str_replace("\n", "<br>\n", $th->getTraceAsString());
}
echo '<br>Done';
