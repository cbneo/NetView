<?php
require "needed/start.php";
if($session['staff'] == 1 && isset($_POST['field_guideline'])) {
  // Prepare the SQL query to insert a new blog post
  $sql = "INSERT INTO c_guidelines (guideline) VALUES (:guideline)";

  // Bind the parameters to the prepared statement
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":guideline", $_POST['field_guideline']);
  
  // Execute the prepared statement
  try {
    $stmt->execute();
    alert("New rule has been established!");
  } catch (PDOException $e) {
    alert("Failed to establish the new rule.", "error");
    exit;
  }
}
$stmt = $conn->query("SELECT * FROM c_guidelines ORDER BY number ASC");
$rowCount = $stmt->rowCount(); // Get the number of rows
?>

<div class="pageTitle">Terms of Use</div>

<div class="pageTable">

1. Your Acceptance 

<br>BY USING AND/OR VISITING THE YUOTOOB WEBSITE, YOU SIGNIFY YOUR ASSENT TO BOTH THESE TERMS AND CONDITIONS OF WEBSITE ACCESS ("TERMS OF SERVICE") AND THE TERMS AND CONDITIONS OF YUOTOOB'S PRIVACY POLICY, WHICH ARE PUBLISHED AT <a href="www.<?php echo $sitedomain; ?>/privacy.php">www.<?php echo $sitedomain; ?>/privacy.php</a>, AND WHICH ARE INCORPORATED HEREIN BY REFERENCE. If you do not agree to any of these terms, please do not use the website. 

<br><br>2. YuoToob Website 

<br>These Terms of Service apply to all users of the <?php echo $sitedomain; ?> Website, including users who are also contributors of video content, information and other materials or services on the Website. The YuoToob Website may contain links to third party websites that are not owned or controlled by YuoToob. YuoToob has no control over, and assumes no responsibility for, the content, privacy policies, or practices of any third party websites. In addition, YuoToob will not and cannot censor or edit the content of any third-party site. By using the Website, you expressly relieve YuoToob from any and all liability arising from your use of any third-party website. Accordingly, we encourage you to be aware when you leave the YuoToob Website, and to read the terms and conditions and privacy policy of each other website that you visit. 

<br><br>3. Website Access 

<br>YuoToob hereby grants you permission to use the Website, provided that: (i) your use of the Website as permitted is solely for your personal, noncommercial use; (ii) you will not copy, republish or rebroadcast any part of the Website in any medium without YuoToob's prior written authorization; (iii) you will not alter or modify any part of the Website other than as may be reasonably necessary to use the Website for its intended purpose; and (iv) you will otherwise comply with the terms and conditions of these Terms of Service. 

<br><br>4. Copyright 

<br>The content on the YuoToob Website, including without limitation the text, software, graphics, photos, and videos ("Content"), is owned by or licensed to YuoToob, subject to copyright and other intellectual property rights under United States Copyright Act, foreign laws, and international conventions. YuoToob reserves all rights not expressly granted in and to the Website and the Content. Other than as expressly permitted, you may not engage in the unauthorized use, copying, or distribution of any of the Content. If you download or print a copy of the Content for personal use, you must retain all copyright and other proprietary notices contained therein. You may not otherwise reproduce, display, publicly perform, or distribute the Content in any way for any public or commercial purpose. 

<br><br>5. Trademarks 

<br>The materials and information on this website, including but not limited to all video, text, graphics, photographs, artwork, and the like ("Content"), as well as the trademarks, service marks and logos contained in our Content, are the intellectual property of YuoToob, it Owners/Operators, its affiliates, and/or its licensors, protected by the Copyright and Trademark Laws of the United States and other jurisdictions. Content is provided to you AS IS for your information and personal use only, and may not be used, copied, reproduced, distributed, transmitted, broadcast, displayed, sold, licensed, or otherwise exploited for any other purposes whatsoever without the prior written consent of the respective owners. Nothing on the Website shall be construed as conferring any license under any of YuoToob?s trademark or other intellectual property rights. 

<br><br>6. User Submissions 

<br>The YuoToob Website may now or in the future permit the publication of videos or other communications submitted by you and other users ("User Submissions"). Any User Submission posted or sent to YuoToob shall automatically be deemed non-confidential. By posting or sending a User Submission, you expressly grant YuoToob a royalty-free, perpetual, irrevocable, non-exclusive, worldwide license to use, reproduce, modify, publish, edit, translate, distribute, perform, display, and make derivative works of such User Submission, and your name, voice, and/or likeness as contained in your User Submission, in whole or in part, and in any form, media or technology, whether now known or hereafter developed, including the unfettered right to sublicense such rights, in perpetuity throughout the universe. 

<br><br>You shall be solely responsible for your own User Submissions and the consequences of posting or publishing them. In connection with User Submissions, you affirm, represent and/or warrant that: (i) You own, or have the necessary licenses, rights, consents, and permissions to use and authorize YuoToob to use, all patent, trademark, trade secret, copyright or other proprietary rights ("Intellectual Property") in and to any and all User Submissions in the manner contemplated by the Website and these Terms of Service; and (ii) You have the written consent, release, and /or permission of each and every identifiable individual person in the User Submission to use the name or likeness of each and every such identifiable individual person in the manner contemplated by the Website and these Terms of Service. 

<br><br>In connection with User Submissions, you further agree that you will not: (i) submit material that is copyrighted, protected by trade secret or otherwise subject to third party proprietary rights, including privacy and publicity rights, unless you are the owner of such rights or have permission from their rightful owner to post the material; (ii) publish falsehoods or misrepresentations that could damage YuoToob or any third party; (iii) submit material that is unlawful, obscene, defamatory, libelous, threatening, pornographic, harassing or encourages conduct that would be considered a criminal offense, give rise to civil liability or violate any law; (iv) post advertisements or solicitations of business: (v) impersonate another person. YuoToob does not endorse any User Submission or any opinion, recommendation or advice expressed therein, and YuoToob expressly disclaims any and all liability in connection with User Submissions. If notified by a user of a User Submission that allegedly does not conform to this Agreement, YuoToob may investigate the allegation and determine in good faith and in its sole discretion whether to remove the User Submission. You affirm that you are either more than 18 years of age or, an emancipated minor or, possess legal parental or guardian consent, and are competent to make this license and release on your own behalf. 

<br><br>You understand that when using the YuoToob Website you will be exposed to User Submissions from a variety of sources, and that YuoToob is not responsible for the accuracy, usefulness, safety, or intellectual property rights of or relating to such User Submissions. You further understand and acknowledge that you may be exposed to User Submissions that are inaccurate, offensive, indecent or objectionable, and you agree to waive, and hereby do waive, any legal or equitable rights or remedies you have or may have against YuoToob with respect thereto, and agree to indemnify and hold YuoToob, its Owners/Operators, affiliates, and/or licensors, harmless to the fullest extent allowed by law regarding all matters related to your use of the site. 

<br><br>7. Warranty Disclaimer 

<br>YOU AGREE THAT YOUR USE OF THE YUOTOOB WEBSITE SHALL BE AT YOUR SOLE RISK. TO THE FULLEST EXTENT PERMITTED BY LAW, YUOTOOB, ITS OFFICERS, DIRECTORS, EMPLOYEES, AND AGENTS DISCLAIM ALL WARRANTIES, EXPRESS OR IMPLIED, IN CONNECTION WITH THE WEBSITE AND YOUR USE THEREOF. YUOTOOB MAKES NO WARRANTIES OR REPRESENTATIONS ABOUT THE ACCURACY OR COMPLETENESS OF THIS SITE?S CONTENT OR THE CONTENT OF ANY SITES LINKED TO THIS SITE, AND ASSUMES NO LIABILITY OR RESPONSIBILITY FOR ANY (I) ERRORS, MISTAKES, OR INACCURACIES OF CONTENT, (II) PERSONAL INJURY OR PROPERTY DAMAGE, OF ANY NATURE WHATSOEVER, RESULTING FROM YOUR ACCESS TO AND USE OF OUR WEBSITE, (III) ANY UNAUTHORIZED ACCESS TO OR USE OF OUR SECURE SERVERS AND/OR ANY AND ALL PERSONAL INFORMATION AND/OR FINANCIAL INFORMATION STORED THEREIN, (IV) ANY INTERRUPTION OR CESSATION OF TRANSMISSION TO OR FROM OUR WEBSITE, (IV) ANY BUGS, VIRUSES, TROJAN HORSES, OR THE LIKE WHICH MAY BE TRANSMITTED TO OR THROUGH OUR WEBSITE BY ANY THIRD PARTY, AND/OR (V) ANY ERRORS OR OMISSIONS IN ANY CONTENT, OR FOR ANY LOSS OR DAMAGE OF ANY KIND INCURRED AS A RESULT OF THE USE OF ANY CONTENT POSTED, EMAILED, TRANSMITTED OR OTHERWISE MADE AVAILABLE VIA THE SERVICE. YUOTOOB DOES NOT WARRANT, ENDORSE, GUARANTEE, OR ASSUME RESPONSIBILITY FOR ANY PRODUCT OR SERVICE ADVERTISED OR OFFERED BY A THIRD PARTY THROUGH THE YUOTOOB WEBSITE OR ANY HYPERLINKED WEBSITE, OR FEATURED IN ANY BANNER OR OTHER ADVERTISING, AND YuoToob WILL NOT BE A PARTY TO OR IN ANY WAY MONITOR ANY TRANSACTION BETWEEN YOU AND THIRD-PARTY PROVIDERS OF PRODUCTS OR SERVICES. AS WITH THE PURCHASE OF A PRODUCT OR SERVICE THROUGH ANY MEDIUM OR IN ANY ENVIRONMENT, YOU SHOULD USE YOUR BEST JUDGMENT AND EXERCISE CAUTION WHERE APPROPRIATE. 

<br><br>8. Limitation of Liability 

<br>IN NO EVENT SHALL YUOTOOB, ITS OFFICERS, DIRECTORS, EMPLOYEES, OR AGENTS, BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, PUNITIVE OR CONSEQUENTIAL DAMAGES WHATSOEVER RESULTING FROM ANY (I) ERRORS, MISTAKES, OR INACCURACIES OF CONTENT, (II) PERSONAL INJURY OR PROPERTY DAMAGE, OF ANY NATURE WHATSOEVER, RESULTING FROM YOUR ACCESS TO AND USE OF OUR WEBSITE, (III) ANY UNAUTHORIZED ACCESS TO OR USE OF OUR SECURE SERVERS AND/OR ANY AND ALL PERSONAL INFORMATION AND/OR FINANCIAL INFORMATION STORED THEREIN, (IV) ANY INTERRUPTION OR CESSATION OF TRANSMISSION TO OR FROM OUR WEBSITE, (IV) ANY BUGS, VIRUSES, TROJAN HORSES, OR THE LIKE WHICH MAY BE TRANSMITTED TO OR THROUGH OUR WEBSITE BY ANY THIRD PARTY, AND/OR (V) ANY ERRORS OR OMISSIONS IN ANY CONTENT, OR FOR ANY LOSS OR DAMAGE OF ANY KIND INCURRED AS A RESULT OF THE USE OF ANY CONTENT POSTED, EMAILED, TRANSMITTED OR OTHERWISE MADE AVAILABLE VIA THE SERVICE, WHETHER BASED ON WARRANTY, CONTRACT, TORT OR ANY OTHER LEGAL THEORY, AND WHETHER OR NOT THE COMPANY IS ADVISED OF THE POSSIBILITY OF SUCH DAMAGES. THE FOREGOING LIMITATION OF LIABILITY SHALL APPLY TO THE FULLEST EXTENT PERMITTED BY LAW IN THE APPLICABLE JURISDICTION. 

<br><br>YOU SPECIFICALLY ACKNOWLEDGE THAT YUOTOOB SHALL NOT BE LIABLE FOR USER SUBMISSIONS OR THE DEFAMATORY, OFFENSIVE, OR ILLEGAL CONDUCT OF ANY THIRD PARTY, AND THAT THE RISK OF HARM OR DAMAGE FROM THE FOREGOING RESTS ENTIRELY WITH YOU. 

<br><br>9. Indemnity 

<br>You agree to defend, indemnify and hold harmless YuoToob, its parent corporation, officers, directors, employees and agents, from and against any and all claims, damages, obligations, losses, liabilities, costs or debt, and expenses (including but not limited to attorney's fees) arising from: (i) your use of and access to the YuoToob Website; (ii) your violation of any term of this Agreement; (iii) your violation of any third party right, including without limitation any copyright, property, or privacy right; or (iv) any claim that one of your User Submissions caused damage to a third party. This defense and indemnification obligation will survive this Agreement and your use of the YuoToob Website. 

<br><br>10. Ability to Accept Terms of Service 

<br>You affirm that you are over the age of 13 and fully able and competent to enter into the terms, conditions, obligations, affirmations, representations and warranties set forth in these Terms of Service, and to abide by and comply with these Terms of Service. 

<br><br>11. General 

<br>You agree that: (i) the YuoToob Website shall be deemed solely based in California; and (ii) the YuoToob Website shall be deemed a passive website that does not give rise to personal jurisdiction over YuoToob, either specific or general, in jurisdictions other than California. This Agreement shall be governed by the internal substantive laws of the State of California, without respect to its conflict of laws principles. Any claim or dispute between you and YuoToob that arises in whole or in part from the YuoToob Website shall be decided exclusively by a court of competent jurisdiction located in San Mateo County, California. This Agreement, together with the Privacy Policy at http://www.<?php echo $sitedomain; ?>/privacy.php and any other legal notices published by YuoToob on the Website, shall constitute the entire agreement between you and YuoToob concerning the YuoToob Website. If any provision of this Agreement is deemed invalid by a court of competent jurisdiction, the invalidity of such provision shall not affect the validity of the remaining provisions of this Agreement, which shall remain in full force and effect. No waiver of any term of this Agreement shall be deemed a further or continuing waiver of such term or any other term, and YuoToob's failure to assert any right or provision under this Agreement shall not constitute a waiver of such right or provision. YuoToob reserves the right to amend this Agreement at any time and without notice, and it is your responsibility to review the Agreement for any changes. Your use of the YuoToob Website following any amendment of this Agreement will signify your assent to and acceptance of its revised terms

</div>

</div>

<br>

<?php require "needed/end.php"; ?>