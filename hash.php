<?php
 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/vendor/autoload.php';

	$Msg='<table border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif;width:100%;max-width:600px;margin:0 auto;border: 1px solid #4f6df5;">
			<tr>
				<td style="padding: 16px 4px 8px;">
					<img src="https://titanww.com/wp-content/uploads/2019/05/TITAN-WORLDWIDE-425-BLACK-179x53.png" style="height:auto;"/>
					<h2 style="margin: 0;font-size: 16px;">LOAD CONFIRMATION: TRIP-300020</h2>
				</td>
			</tr>
			<tr>
				<td>
					<table border="0" cellpadding="0" cellspacing="0" style="width: 100%;background: #4f6df5;color: #fff;font-size: 13px;line-height:21px;">
						<tr>
							<td style="padding:5px;">
								<div>Carrier: Triangle J Inc</div>
								<div>Attention: Chris Pedigo</div>
								<div>Equip. Req.: 48\' or 53\' Flatbed</div>
								<div>Phone: (912) 693-1977</div>
							</td>
							<td style="padding:5px;">
								<div>Titan Worldwide</div>
								<div>633 W Davis St. #519<br>
								Dallas, TX 75208</div>
								<div>Tel: (346) 291-3350</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table border="0" cellpadding="0" cellspacing="0" style="width: 100%;font-size: 13px;font-weight: 600;border-bottom: 1px dashed #4f6df5;padding: 5px 2px 4px;">
						<tr><td style="text-align:left;">Shipment 1</td><td style="text-align:right;">PRO-50018</td></tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table border="0" cellpadding="0" cellspacing="0" style="width:100%;">
						<tr>
							<td style="vertical-align: top;padding: 5px 5px 0;"> 
								<span style="font-size: 13px;font-weight: 600;display: block;line-height:21px;">Pickup Date</span>
								<div style="font-size: 13px;line-height: 17px;">May 29, 2019</div>
							</td>
							<td style="vertical-align: top;padding: 5px 5px 0;"> 
								<span style="font-size: 13px;font-weight: 600;display: block;line-height:21px;">Delivery Date</span>
								<div style="font-size: 13px;line-height: 17px;">May 31, 2019</div>
							</td>
						</tr>
						<tr>
							<td colspan="2"  style="vertical-align: top;padding: 5px 5px 0;">
								<span style="font-size: 13px;font-weight: 600;display: block;line-height:21px;">Commodity</span>
								<div style="font-size: 13px;line-height: 17px;">BUILDING MATERIAL - ACCESS LADDERS & PLATFORMS; 1 pieces; 30,000.00 lbs; 53.00 (L) x 10.00 (W) x 8.00 (H);Over Dimensional</div>
							</td>
						</tr>
						<tr>
							<td style="vertical-align: top;padding: 5px 5px 0;"> 
								<span style="font-size: 13px;font-weight: 600;display: block;line-height:21px;">Shipper</span>
								<div style="font-size: 13px;line-height: 17px;">Bid-DELTECH AUGUSTA DIVISION<br> 
									 930 Molly Pond Rd<br>
									 Augusta, GA 30901<br>
									 Shipping Dept - Andy Dyke, (843) 636-2386
								</div>
							</td>
							<td style="vertical-align: top;padding: 5px 5px 0;"> 
								<span style="font-size: 13px;font-weight: 600;display: block;line-height:21px;">Consignee</span>
								<div style="font-size: 13px;line-height: 17px;">LASALLE LUMBER, BID<br>
									5189 HWY 125<br>
									Olla, LA 71465<br>
									Greg McManus Tony Mendes, 
									(843) 560-0052
								</div>
							</td>
						</tr>							
						<tr>
							<td style="vertical-align: top;padding: 5px 5px 0;"> 
								<span style="font-size: 13px;font-weight: 600;display: block;line-height:21px;">Loading Info</span>
								<div style="font-size: 13px;line-height: 17px;">Hours of Operation: Mon-Thurs 7:30AM-4PM Friday 7:30AM-3PM, CALL WITH ETA - Check with site regarding after hours or weekend assistance
								</div>
							</td>
							<td style="vertical-align: top;padding: 5px 5px 0;"> 
								<span style="font-size: 13px;font-weight: 600;display: block;line-height:21px;">Receiving Info</span>
								<div style="font-size: 13px;line-height: 17px;">Hours - Mon-Fri 8am-4:30pm
									**CALL WITH ETA ONCE LOADED TO
									NOTIFY THE LOAD/OFFLOAD CREW AS
									THEY WILL NORMALLY ACCOMMODATE
									AFTER HOURS AND WEEKEND RECEIVING
									WITH ADVANCE NOTICE**
									Gary Doucet or Taylor Dubois at 843-560-
									3767 or 843-563-7070
								</div>
							</td>
						</tr>
						<tr>
							<td style="vertical-align: top;padding: 5px 5px 0;padding-bottom: 8px;"> 
								<span style="font-size: 13px;font-weight: 600;display: block;line-height:21px;">Pickup Note</span>
								<div style="font-size: 13px;line-height: 17px;">LOAD 05.29.2019 - HOURS: MON-FRI 7:30AM-
									3PM **GET DELIVERY CONTACT FROM PICKUP
									SITE**
									48-53ft FLATBED WIDE LOAD
									ACCESS LADDERS AND PLATFORMS
									DIMS NOT TO EXCEED 53 X 10 X 8 APPROX
									30000 LBS.
								</div>
							</td>
							<td style="vertical-align: top;padding: 5px 5px 0;padding-bottom: 8px;"> 
								<span style="font-size: 13px;font-weight: 600;display: block;line-height:21px;">Delivery Note</span>
								<div style="font-size: 13px;line-height: 17px;">Deliver next day or by 05.31.2019
									DELIVERY HOURS 8AM-4:30PM ***MUST
									CALL WITH ETA ONCE LOADED TO NOTIFY
									ONSITE CREW - THEY CAN ASSIST AFTER
									HOURS AND WEEKENDS AS NEEDED
									WITH ADVANCE NOTICE ***
								</div>
							</td>
						</tr>



					
					</table>
				</td>
			</tr>
			<tr>
				<td style="text-align:center;text-align: center;border: solid #4f6df5;border-width: 1px 0;padding: 4px;font-size: 13px;font-weight: 600;">
					In case of delays or problems, please call Bryan Thompson at (346) 291-3773
				</td>
			</tr>	
			<tr>
				<td style="padding:10px;">
					<table border="0" cellpadding="0" cellspacing="0" style="width:100%;border: 1px solid #ccc;font-size: 13px;"> 
						<tr><td style="border-bottom: 1px solid #ccc;padding: 2px;" colspan="2">Charge Description</td><td style="border-bottom: 1px solid #ccc;padding: 2px;">Amount</td></tr>
						<tr><td style="border-bottom: 1px solid #ccc;padding: 2px;" colspan="2">Driver Expense (Carrier Pay)</td><td style="border-bottom: 1px solid #ccc;padding: 2px;">$2,800.00</td></tr>
						<tr><td style="padding:2px;">USD Total</td><td style="padding:2px;text-align: center;">(All Inclusive Rate - INCL FUEL SURCHARGES)</td><td style="padding:2px;">$2,800.00</td></tr>
						
						<tr><td colspan="3">
							<table border="0" cellpadding="0" cellspacing="0" style="width:100%;">
								<tr><td style="padding:2px;width:60%;">Signature:</td><td style="padding:2px;width:40%;" >Date:</td></tr>
								<tr><td style="padding:2px;width:60%;">Carrier Pro#:</td><td style="padding:2px;width:40%;">Driver\'s Cell#:
								</td></tr>
							</table>
						</td></tr>
					</table>
				</td>
			</tr>
			<tr>
				<td style="padding:8px;background:#000;color:#fff;">
					<table border="0" cellpadding="0" cellspacing="0">
						<tr><td>
						<h2 style="text-align: center;margin: 0px;font-size: 14px;color:#fff;">PLEASE SIGN and email to <a style="color:#fff;">dispatch@titanww.com</a></h2>
						<p style="text-align:justify;color:#fff;margin: 0;font-size: 13px;padding-top: 6px;">Loading Terms: Problems and delays must be reported immediately. Costs resulting from delays may be deducted from freight charges. This load confirmation number must appear on Carriers invoice. Payment is issued 30 days from receipt of carrier invoice and proof of delivery with no exceptions noted, unless other payment terms were negotiated. Email invoice and delivery documents to <a style="color:#fff;">carrier.invoices@titanww.com</a></p>
						</td></tr>
					</table>
				</td>
			</tr>
		</table>';

	$mail = new PHPMailer(true); 

    $mail->SMTPDebug = 1;
    $mail->isSMTP();
    $mail->Host = 'mail.africafilmclub.com';
    $mail->SMTPAuth = true;        
    $mail->Username = 'info@africafilmclub.com';
    $mail->Password = '123456789';                           
    $mail->SMTPSecure = 'tsl';                            
    $mail->Port = 587;                                   
    $mail->setFrom('no-replay@africafilmclub.com', 'Africa Film Club');
    $mail->addAddress('deepak.outsourcingtech@gmail.com','Name');
    $mail->addReplyTo('replay@africafilmclub.com', 'Africa Film Club');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');
    // $mail->addAttachment('/var/tmp/file.tar.gz');

    $mail->isHTML(true);                                   
    $mail->Subject = 'Here is the subject';
    $mail->Body = $Msg;
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	$mail->send();
?>
