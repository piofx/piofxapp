<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("mail_templates")->insert([
            'id' => '1',
            'agency_id' => '1',
            'client_id' => '1',
            'user_id' => '1',
            'name' => 'template1',
            'slug' => 'slug1',
            'subject' => 'some sample subject',
            'message' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <title>[SUBJECT]</title>
                <style type="text/css">
                  @media screen and (max-width: 600px) {
                    table[class="container"] {
                      width: 95% !important;
                    }
                  }
            
                  #outlook a {
                    padding: 0;
                  }
                  body {
                    width: 100% !important;
                    -webkit-text-size-adjust: 100%;
                    -ms-text-size-adjust: 100%;
                    margin: 0;
                    padding: 0;
                  }
                  .ExternalClass {
                    width: 100%;
                  }
                  .ExternalClass,
                  .ExternalClass p,
                  .ExternalClass span,
                  .ExternalClass font,
                  .ExternalClass td,
                  .ExternalClass div {
                    line-height: 100%;
                  }
                  #backgroundTable {
                    margin: 0;
                    padding: 0;
                    width: 100% !important;
                    line-height: 100% !important;
                  }
                  img {
                    outline: none;
                    text-decoration: none;
                    -ms-interpolation-mode: bicubic;
                  }
                  a img {
                    border: none;
                  }
                  .image_fix {
                    display: block;
                  }
                  p {
                    margin: 1em 0;
                  }
                  h1,
                  h2,
                  h3,
                  h4,
                  h5,
                  h6 {
                    color: black !important;
                  }
            
                  h1 a,
                  h2 a,
                  h3 a,
                  h4 a,
                  h5 a,
                  h6 a {
                    color: blue !important;
                  }
            
                  h1 a:active,
                  h2 a:active,
                  h3 a:active,
                  h4 a:active,
                  h5 a:active,
                  h6 a:active {
                    color: red !important;
                  }
            
                  h1 a:visited,
                  h2 a:visited,
                  h3 a:visited,
                  h4 a:visited,
                  h5 a:visited,
                  h6 a:visited {
                    color: purple !important;
                  }
            
                  table td {
                    border-collapse: collapse;
                  }
            
                  table {
                    border-collapse: collapse;
                    mso-table-lspace: 0pt;
                    mso-table-rspace: 0pt;
                  }
            
                  a {
                    color: #000;
                  }
            
                  @media only screen and (max-device-width: 480px) {
                    a[href^="tel"],
                    a[href^="sms"] {
                      text-decoration: none;
                      color: black; /* or whatever your want */
                      pointer-events: none;
                      cursor: default;
                    }
            
                    .mobile_link a[href^="tel"],
                    .mobile_link a[href^="sms"] {
                      text-decoration: default;
                      color: orange !important; /* or whatever your want */
                      pointer-events: auto;
                      cursor: default;
                    }
                  }
            
                  @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
                    a[href^="tel"],
                    a[href^="sms"] {
                      text-decoration: none;
                      color: blue; /* or whatever your want */
                      pointer-events: none;
                      cursor: default;
                    }
            
                    .mobile_link a[href^="tel"],
                    .mobile_link a[href^="sms"] {
                      text-decoration: default;
                      color: orange !important;
                      pointer-events: auto;
                      cursor: default;
                    }
                  }
            
                  @media only screen and (-webkit-min-device-pixel-ratio: 2) {
                    /* Put your iPhone 4g styles in here */
                  }
            
                  @media only screen and (-webkit-device-pixel-ratio: 0.75) {
                    /* Put CSS for low density (ldpi) Android layouts in here */
                  }
                  @media only screen and (-webkit-device-pixel-ratio: 1) {
                    /* Put CSS for medium density (mdpi) Android layouts in here */
                  }
                  @media only screen and (-webkit-device-pixel-ratio: 1.5) {
                    /* Put CSS for high density (hdpi) Android layouts in here */
                  }
                  /* end Android targeting */
                  h2 {
                    color: #181818;
                    font-family: Helvetica, Arial, sans-serif;
                    font-size: 22px;
                    line-height: 22px;
                    font-weight: normal;
                  }
                  a.link1 {
                  }
                  a.link2 {
                    color: #fff;
                    text-decoration: none;
                    font-family: Helvetica, Arial, sans-serif;
                    font-size: 16px;
                    color: #fff;
                    border-radius: 4px;
                  }
                  p {
                    color: #555;
                    font-family: Helvetica, Arial, sans-serif;
                    font-size: 16px;
                    line-height: 160%;
                  }
                </style>
            
                <script type="colorScheme" class="swatch active">
                  {
                    "name":"Default",
                    "bgBody":"ffffff",
                    "link":"fff",
                    "color":"555555",
                    "bgItem":"ffffff",
                    "title":"181818"
                  }
                </script>
              </head>
              <body>
                <!-- Wrapper/Container Table: Use a wrapper table to control the width and the background color consistently of your email. Use this approach instead of setting attributes on the body tag. -->
                <table
                  cellpadding="0"
                  width="100%"
                  cellspacing="0"
                  border="0"
                  id="backgroundTable"
                  class="bgBody"
                >
                  <tr>
                    <td>
                      <table
                        cellpadding="0"
                        width="620"
                        class="container"
                        align="center"
                        cellspacing="0"
                        border="0"
                      >
                        <tr>
                          <td>
                            <!-- Tables are the most common way to format your email consistently. Set your table widths inside cells and in most cases reset cellpadding, cellspacing, and border to zero. Use nested tables as a way to space effectively in your message. -->
            
                            <table
                              cellpadding="0"
                              cellspacing="0"
                              border="0"
                              align="center"
                              width="600"
                              class="container"
                            >
                              <tr>
                                <td class="movableContentContainer bgItem">
                                  <div class="movableContent">
                                    <table
                                      cellpadding="0"
                                      cellspacing="0"
                                      border="0"
                                      align="center"
                                      width="600"
                                      class="container"
                                    >
                                      <tr height="40">
                                        <td width="200">&nbsp;</td>
                                        <td width="200">&nbsp;</td>
                                        <td width="200">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td width="200" valign="top">&nbsp;</td>
                                        <td width="200" valign="top" align="center">
                                          <div
                                            class="
                                              contentEditableContainer
                                              contentImageEditable
                                            "
                                          >
                                            <div class="contentEditable" align="center">
                                              <img
                                                src="https://trimitiy.com/assets/images/logo/new-logo-white.png"
                                                width="155"
                                                height="155"
                                                alt="Logo"
                                                data-default="placeholder"
                                              />
                                            </div>
                                          </div>
                                        </td>
                                        <td width="200" valign="top">&nbsp;</td>
                                      </tr>
                                      <tr height="25">
                                        <td width="200">&nbsp;</td>
                                        <td width="200">&nbsp;</td>
                                        <td width="200">&nbsp;</td>
                                      </tr>
                                    </table>
                                  </div>
            
                                  <div class="movableContent">
                                    <table
                                      cellpadding="0"
                                      cellspacing="0"
                                      border="0"
                                      align="center"
                                      width="600"
                                      class="container"
                                    >
                                      <tr>
                                        <td
                                          width="100%"
                                          colspan="3"
                                          align="center"
                                          style="padding-bottom: 10px; padding-top: 25px"
                                        >
                                          <div
                                            class="
                                              contentEditableContainer
                                              contentTextEditable
                                            "
                                          >
                                            <div class="contentEditable" align="center">
                                              <h2>Its been a while...</h2>
                                            </div>
                                          </div>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td width="100">&nbsp;</td>
                                        <td width="400" align="center">
                                          <div
                                            class="
                                              contentEditableContainer
                                              contentTextEditable
                                            "
                                          >
                                            <div class="contentEditable" align="left">
                                              <p>
                                                Hi ,
                                                {{ $count }}
                                                people subscribed!!
                                                <br />
                                                <br />
                                                Click on the link below to update your
                                                profile. If you are no longer interested in
                                                hearing from us, simply click on unsubscribe
                                                below (or ignore this message) and we wont
                                                send you any more newsletters.
                                              </p>
                                            </div>
                                          </div>
                                        </td>
                                        <td width="100">&nbsp;</td>
                                      </tr>
                                    </table>
                                    <table
                                      cellpadding="0"
                                      cellspacing="0"
                                      border="0"
                                      align="center"
                                      width="600"
                                      class="container"
                                    >
                                      <tr>
                                        <td width="200">&nbsp;</td>
                                        <td
                                          width="200"
                                          align="center"
                                          style="padding-top: 25px"
                                        >
                                          <table
                                            cellpadding="0"
                                            cellspacing="0"
                                            border="0"
                                            align="center"
                                            width="200"
                                            height="50"
                                          >
                                            <tr>
                                              <td
                                                bgcolor="#ED006F"
                                                align="center"
                                                style="border-radius: 4px"
                                                width="200"
                                                height="50"
                                              >
                                                <div
                                                  class="
                                                    contentEditableContainer
                                                    contentTextEditable
                                                  "
                                                >
                                                  <div
                                                    class="contentEditable"
                                                    align="center"
                                                  >
                                                    <a
                                                      target="_blank"
                                                      href="#"
                                                      class="link2"
                                                      >Click here to reset it</a
                                                    >
                                                  </div>
                                                </div>
                                              </td>
                                            </tr>
                                          </table>
                                        </td>
                                        <td width="200">&nbsp;</td>
                                      </tr>
                                    </table>
                                  </div>
            
                                  <div class="movableContent">
                                    <table
                                      cellpadding="0"
                                      cellspacing="0"
                                      border="0"
                                      align="center"
                                      width="600"
                                      class="container"
                                    >
                                      <tr>
                                        <td
                                          width="100%"
                                          colspan="2"
                                          style="padding-top: 65px"
                                        >
                                          <hr
                                            style="
                                              height: 1px;
                                              border: none;
                                              color: #333;
                                              background-color: #ddd;
                                            "
                                          />
                                        </td>
                                      </tr>
                                      <tr>
                                        <td
                                          width="60%"
                                          height="70"
                                          valign="middle"
                                          style="padding-bottom: 20px"
                                        >
                                          <div
                                            class="
                                              contentEditableContainer
                                              contentTextEditable
                                            "
                                          >
                                            <div class="contentEditable" align="left">
                                              <span
                                                style="
                                                  font-size: 13px;
                                                  color: #181818;
                                                  font-family: Helvetica, Arial, sans-serif;
                                                  line-height: 200%;
                                                "
                                                >Sent to [email] by
                                                [CLIENTS.COMPANY_NAME]</span
                                              >
                                              <br />
                                              <span
                                                style="
                                                  font-size: 11px;
                                                  color: #555;
                                                  font-family: Helvetica, Arial, sans-serif;
                                                  line-height: 200%;
                                                "
                                                >[CLIENTS.ADDRESS] | [CLIENTS.PHONE]</span
                                              >
                                              <br />
                                              <span
                                                style="
                                                  font-size: 13px;
                                                  color: #181818;
                                                  font-family: Helvetica, Arial, sans-serif;
                                                  line-height: 200%;
                                                "
                                              >
                                                <a
                                                  target="_blank"
                                                  href="[FORWARD]"
                                                  style="text-decoration: none; color: #555"
                                                  >Forward to a friend</a
                                                >
                                              </span>
                                              <br />
                                              <span
                                                style="
                                                  font-size: 13px;
                                                  color: #181818;
                                                  font-family: Helvetica, Arial, sans-serif;
                                                  line-height: 200%;
                                                "
                                              >
                                                <a
                                                  target="_blank"
                                                  href="[UNSUBSCRIBE]"
                                                  style="text-decoration: none; color: #555"
                                                  >click here to unsubscribe</a
                                                ></span
                                              >
                                            </div>
                                          </div>
                                        </td>
                                        <td
                                          width="40%"
                                          height="70"
                                          align="right"
                                          valign="top"
                                          align="right"
                                          style="padding-bottom: 20px"
                                        >
                                          <table
                                            width="100%"
                                            border="0"
                                            cellspacing="0"
                                            cellpadding="0"
                                            align="right"
                                          >
                                            <tr>
                                              <td width="57%"></td>
                                              <td valign="top" width="34">
                                                <div
                                                  class="
                                                    contentEditableContainer
                                                    contentFacebookEditable
                                                  "
                                                  style="display: inline"
                                                >
                                                  <div class="contentEditable">
                                                    <img
                                                      src="https://1000logos.net/wp-content/uploads/2021/04/Facebook-logo.png"
                                                      data-default="placeholder"
                                                      data-max-width="30"
                                                      data-customIcon="true"
                                                      width="60"
                                                      height="40"
                                                      alt="facebook"
                                                      style="margin-right: 40x"
                                                    />
                                                  </div>
                                                </div>
                                              </td>
                                              <td valign="top" width="34">
                                                <div
                                                  class="
                                                    contentEditableContainer
                                                    contentTwitterEditable
                                                  "
                                                  style="display: inline"
                                                >
                                                  <div class="contentEditable">
                                                    <img
                                                      src="https://i.pinimg.com/236x/b7/91/26/b79126d537c628d7ac5429f7f84ffc8e--twitter-logo-twitter-icon.jpg"
                                                      data-default="placeholder"
                                                      data-max-width="30"
                                                      data-customIcon="true"
                                                      width="45"
                                                      height="45"
                                                      alt="twitter"
                                                      style="margin-right: 40x"
                                                    />
                                                  </div>
                                                </div>
                                              </td>
                                            </tr>
                                          </table>
                                        </td>
                                      </tr>
                                    </table>
                                  </div>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
                <!-- End of wrapper table -->
              </body>
            </html>',
            'status' => "1",
        ]);

        DB::table("mail_templates")->insert([
            'id' => '2',
            'agency_id' => '1',
            'client_id' => '1',
            'user_id' => '1',
            'name' => 'template2',
            'slug' => 'slug2',
            'subject' => 'some sample subject',
            'message' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
              <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>[SUBJECT]</title>
                <style type="text/css">
                  body {
                    padding-top: 0 !important;
                    padding-bottom: 0 !important;
                    padding-top: 0 !important;
                    padding-bottom: 0 !important;
                    margin: 0 !important;
                    width: 100% !important;
                    -webkit-text-size-adjust: 100% !important;
                    -ms-text-size-adjust: 100% !important;
                    -webkit-font-smoothing: antialiased !important;
                  }
                  .tableContent img {
                    border: 0 !important;
                    display: block !important;
                    outline: none !important;
                  }
                  a {
                    color: #382f2e;
                  }
            
                  p,
                  h1,
                  ul,
                  ol,
                  li,
                  div {
                    margin: 0;
                    padding: 0;
                  }
            
                  td,
                  table {
                    vertical-align: top;
                  }
                  td.middle {
                    vertical-align: middle;
                  }
            
                  a.link1 {
                    color: #ffffff;
                    font-size: 14px;
                    text-decoration: none;
                  }
            
                  a.link2 {
                    font-size: 13px;
                    color: #999999;
                    text-decoration: none;
                    line-height: 19px;
                  }
            
                  .bigger {
                    font-size: 24px;
                  }
                  .bgBody {
                    background: #dddddd;
                  }
                  .bgItem {
                    background: #ffffff;
                  }
                  h2 {
                    font-family: Georgia;
                    font-size: 36px;
                    text-align: center;
                    color: #b57801;
                    font-weight: normal;
                  }
                  p {
                    color: #ffffff;
                  }
            
                  @media only screen and (max-width: 480px) {
                    table[class="MainContainer"],
                    td[class="cell"] {
                      width: 100% !important;
                      height: auto !important;
                    }
                    td[class="specbundle"] {
                      width: 100% !important;
                      float: left !important;
                      font-size: 13px !important;
                      line-height: 17px !important;
                      display: block !important;
                      padding-bottom: 15px !important;
                    }
                    td[class="specbundle2"] {
                      width: 90% !important;
                      float: left !important;
                      font-size: 14px !important;
                      line-height: 18px !important;
                      display: block !important;
                      padding-bottom: 10px !important;
                      padding-left: 5% !important;
                      padding-right: 5% !important;
                    }
            
                    td[class="spechide"] {
                      display: none !important;
                    }
                    img[class="banner"] {
                      width: 100% !important;
                      height: auto !important;
                    }
                    td[class="left_pad"] {
                      padding-left: 15px !important;
                      padding-right: 15px !important;
                    }
                  }
            
                  @media only screen and (max-width: 540px) {
                    table[class="MainContainer"],
                    td[class="cell"] {
                      width: 100% !important;
                      height: auto !important;
                    }
                    td[class="specbundle"] {
                      width: 100% !important;
                      float: left !important;
                      font-size: 13px !important;
                      line-height: 17px !important;
                      display: block !important;
                      padding-bottom: 15px !important;
                    }
                    td[class="specbundle2"] {
                      width: 90% !important;
                      float: left !important;
                      font-size: 14px !important;
                      line-height: 18px !important;
                      display: block !important;
                      padding-bottom: 10px !important;
                      padding-left: 5% !important;
                      padding-right: 5% !important;
                    }
            
                    td[class="spechide"] {
                      display: none !important;
                    }
                    img[class="banner"] {
                      width: 100% !important;
                      height: auto !important;
                    }
                    td[class="left_pad"] {
                      padding-left: 15px !important;
                      padding-right: 15px !important;
                    }
                  }
                </style>
                <script type="colorScheme" class="swatch active">
                  {
                    "name":"Default",
                    "bgBody":"DDDDDD",
                    "link":"999999",
                    "color":"ffffff",
                    "bgItem":"ffffff",
                    "title":"B57801"
                  }
                </script>
              </head>
              <body
                paddingwidth="0"
                paddingheight="0"
                class="bgBody"
                style="
                  padding-top: 0;
                  padding-bottom: 0;
                  padding-top: 0;
                  padding-bottom: 0;
                  background-repeat: repeat;
                  width: 100% !important;
                  -webkit-text-size-adjust: 100%;
                  -ms-text-size-adjust: 100%;
                  -webkit-font-smoothing: antialiased;
                "
                offset="0"
                toppadding="0"
                leftpadding="0"
              >
                <table
                  width="100%"
                  border="0"
                  cellspacing="0"
                  cellpadding="0"
                  class="tableContent bgBody"
                  align="center"
                  style="font-family: helvetica, sans-serif"
                >
                  <!-- ================ header=============== -->
                  <tbody>
                    <tr>
                      <td>
                        <table
                          width="600"
                          border="0"
                          cellspacing="0"
                          cellpadding="0"
                          align="center"
                          class="MainContainer"
                        >
                          <tbody>
                            <tr>
                              <td class="movableContentContainer">
                                <div
                                  class="movableContent"
                                  style="border: 0px; padding-top: 0px; position: relative"
                                >
                                  <table
                                    width="100%"
                                    border="0"
                                    cellspacing="0"
                                    cellpadding="0"
                                  >
                                    <tbody>
                                      <tr>
                                        <td height="22" bgcolor="#272727"></td>
                                      </tr>
                                      <tr>
                                        <td bgcolor="#272727">
                                          <table
                                            width="100%"
                                            border="0"
                                            cellspacing="0"
                                            cellpadding="0"
                                          >
                                            <tbody>
                                              <tr>
                                                <td
                                                  valign="top"
                                                  width="20"
                                                  class="spechide"
                                                >
                                                  &nbsp;
                                                </td>
                                                <td>
                                                  <table
                                                    width="100%"
                                                    border="0"
                                                    cellspacing="0"
                                                    cellpadding="0"
                                                  >
                                                    <tbody>
                                                      <tr>
                                                        <td
                                                          valign="top"
                                                          width="340"
                                                          class="specbundle2"
                                                        >
                                                          <div
                                                            class="
                                                              contentEditableContainer
                                                              contentImageEditable
                                                            "
                                                          >
                                                            <div class="contentEditable">
                                                              <img
                                                                src="images/logo.png"
                                                                data-max-width="340"
                                                                alt="[CLIENTS.COMPANY_NAME]"
                                                              />
                                                            </div>
                                                          </div>
                                                        </td>
                                                        <td
                                                          valign="top"
                                                          class="specbundle2"
                                                          align="right"
                                                        >
                                                          <div
                                                            class="
                                                              contentEditableContainer
                                                              contentTextEditable
                                                            "
                                                          >
                                                            <div
                                                              style="font-size: 14px"
                                                              class="contentEditable"
                                                            >
                                                              <p>
                                                                <a
                                                                  target="_blank"
                                                                  href="#"
                                                                  class="link1"
                                                                  >About us</a
                                                                >
                                                                /
                                                                <a
                                                                  target="_blank"
                                                                  href="#"
                                                                  class="link1"
                                                                  >Contact</a
                                                                >
                                                                /
                                                                <a
                                                                  target="_blank"
                                                                  href="#"
                                                                  class="link1"
                                                                  >Menu</a
                                                                >
                                                              </p>
                                                            </div>
                                                          </div>
                                                        </td>
                                                      </tr>
                                                    </tbody>
                                                  </table>
                                                </td>
                                                <td
                                                  valign="top"
                                                  width="20"
                                                  class="spechide"
                                                >
                                                  &nbsp;
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td height="22" bgcolor="#272727"></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <div
                                  class="movableContent"
                                  style="border: 0px; padding-top: 0px; position: relative"
                                >
                                  <table
                                    width="100%"
                                    border="0"
                                    cellspacing="0"
                                    cellpadding="0"
                                  >
                                    <tr>
                                      <td height="22" bgcolor="#272727"></td>
                                    </tr>
                                    <tr>
                                      <td bgcolor="#B57801">
                                        <div
                                          class="
                                            contentEditableContainer
                                            contentImageEditable
                                          "
                                        >
                                          <div class="contentEditable">
                                            <img
                                              class="banner"
                                              src="https://c4.wallpaperflare.com/wallpaper/371/69/249/happy-new-year-champagne-stemware-ribbon-wallpaper-preview.jpg"
                                              data-default="placeholder"
                                              data-max-width="600"
                                              width="600"
                                              height="400"
                                              alt="Happy New Year!"
                                              border="0"
                                            />
                                          </div>
                                        </div>
                                      </td>
                                    </tr>
                                  </table>
                                </div>
                                <div
                                  class="movableContent"
                                  style="border: 0px; padding-top: 0px; position: relative"
                                >
                                  <table
                                    width="100%"
                                    border="0"
                                    cellspacing="0"
                                    cellpadding="0"
                                    bgcolor="#B57801"
                                  >
                                    <tr>
                                      <td height="55" colspan="3"></td>
                                    </tr>
                                    <tr>
                                      <td width="125"></td>
                                      <td>
                                        <table
                                          width="350"
                                          border="0"
                                          cellspacing="0"
                                          cellpadding="0"
                                        >
                                          <tr>
                                            <td>
                                              <div
                                                class="
                                                  contentEditableContainer
                                                  contentTextEditable
                                                "
                                              >
                                                <div
                                                  style="
                                                    font-family: Georgia;
                                                    text-align: center;
                                                  "
                                                  class="contentEditable"
                                                >
                                                  <p
                                                    style="font-size: 36px; color: #ffffff"
                                                  >
                                                    Happy New Year! [firstname, buddy]!
                                                  </p>
                                                </div>
                                              </div>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td height="25"></td>
                                          </tr>
                                          <tr>
                                            <td>
                                              <div
                                                class="
                                                  contentEditableContainer
                                                  contentTextEditable
                                                "
                                              >
                                                <div
                                                  style="
                                                    font-family: Georgia;
                                                    font-size: 15px;
                                                    line-height: 17px;
                                                    text-align: center;
                                                  "
                                                  class="contentEditable"
                                                >
                                                  <p>
                                                    Being a good marketer is all about
                                                    creating good habits and sticking to
                                                    them.  As we usher in [DATE|86750|Y],
                                                    we’re counting down our very own top ten
                                                    marketing resolutions - feel free to
                                                    steal any (or all!) of them.
                                                  </p>
                                                </div>
                                              </div>
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                      <td width="125"></td>
                                    </tr>
                                    <tr>
                                      <td height="55" colspan="3"></td>
                                    </tr>
                                  </table>
                                </div>
                                <div
                                  class="movableContent"
                                  style="border: 0px; padding-top: 0px; position: relative"
                                >
                                  <table
                                    width="100%"
                                    border="0"
                                    cellspacing="0"
                                    cellpadding="0"
                                    bgcolor="#B57801"
                                  >
                                    <tr>
                                      <td height="30"></td>
                                    </tr>
                                    <tr>
                                      <td width="600">
                                        <div
                                          class="
                                            contentEditableContainer
                                            contentTextEditable
                                          "
                                        >
                                          <div
                                            style="
                                              font-family: Georgia;
                                              font-size: 20px;
                                              text-align: center;
                                              line-height: 32px;
                                            "
                                            class="contentEditable"
                                          >
                                            <p>
                                              Happy Holidays<br />
                                              from everyone at [CLIENTS.COMPANY_NAME]!
                                            </p>
                                          </div>
                                        </div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td height="30"></td>
                                    </tr>
                                  </table>
                                </div>
                                <div
                                  class="movableContent"
                                  style="border: 0px; padding-top: 0px; position: relative"
                                >
                                  <table
                                    width="100%"
                                    border="0"
                                    cellspacing="0"
                                    cellpadding="0"
                                  >
                                    <tr>
                                      <td height="180" class="bgItem" align="center">
                                        <table
                                          width="100%"
                                          border="0"
                                          cellspacing="0"
                                          cellpadding="0"
                                        >
                                          <tr>
                                            <td height="55"></td>
                                          </tr>
                                          <tr>
                                            <td align="center">
                                              <div
                                                class="
                                                  contentEditableContainer
                                                  contentTextEditable
                                                "
                                              >
                                                <div
                                                  style="font-size: 13px; font-weight: bold"
                                                  class="contentEditable"
                                                >
                                                  <p style="color: #999999">
                                                    Sent to [email] by
                                                    [CLIENTS.COMPANY_NAME] |
                                                    [CLIENTS.ADDRESS] | [CLIENTS.PHONE]
                                                  </p>
                                                </div>
                                              </div>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td height="10"></td>
                                          </tr>
                                          <tr>
                                            <td align="center" style="font-size: 13px">
                                              <div
                                                class="
                                                  contentEditableContainer
                                                  contentTextEditable
                                                "
                                              >
                                                <div class="contentEditable">
                                                  <p style="color: #999999">
                                                    <a
                                                      target="_blank"
                                                      href="[CLIENTS.WEBSITE]"
                                                      class="link2"
                                                      >Home</a
                                                    >
                                                    |
                                                    <a
                                                      target="_blank"
                                                      href="[SHOWEMAIL]"
                                                      class="link2"
                                                    >
                                                      Open in browser
                                                    </a>
                                                    |
                                                    <a
                                                      target="_blank"
                                                      href="[FORWARD]"
                                                      class="link2"
                                                      >Forward to a friend</a
                                                    >
                                                    |
                                                    <a
                                                      target="_blank"
                                                      href="[UNSUBSCRIBE]"
                                                      class="link2"
                                                      >Unsubscribe</a
                                                    >
                                                  </p>
                                                </div>
                                              </div>
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                    </tr>
                                  </table>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </body>
            </html>
            
            ',
            'status' => "1",
        ]);

        DB::table("mail_templates")->insert([
          'id' => '3',
          'agency_id' => '1',
          'client_id' => '1',
          'user_id' => '1',
          'name' => 'Welcome Mail',
          'slug' => 'slug3',
          'subject' => 'some sample subject',
          'message' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
          <html
            xmlns="http://www.w3.org/1999/xhtml"
            xmlns:v="urn:schemas-microsoft-com:vml"
            xmlns:o="urn:schemas-microsoft-com:office:office"
          >
            <head>
              <!--[if gte mso 9]>
                <xml>
                  <o:OfficeDocumentSettings>
                    <o:AllowPNG />
                    <o:PixelsPerInch>96</o:PixelsPerInch>
                  </o:OfficeDocumentSettings>
                </xml>
              <![endif]-->
              <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
              <meta
                name="viewport"
                content="width=device-width, initial-scale=1, maximum-scale=1"
              />
              <meta http-equiv="X-UA-Compatible" content="IE=edge" />
              <meta name="format-detection" content="date=no" />
              <meta name="format-detection" content="address=no" />
              <meta name="format-detection" content="telephone=no" />
              <meta name="x-apple-disable-message-reformatting" />
              <!--[if !mso]><!-->
              <link
                href="https://fonts.googleapis.com/css?family=Muli:400,400i,700,700i"
                rel="stylesheet"
              />
              <!--<![endif]-->
              <title>Email Template</title>
              <!--[if gte mso 9]>
                <style type="text/css" media="all">
                  sup {
                    font-size: 100% !important;
                  }
                </style>
              <![endif]-->
          
              <style type="text/css" media="screen">
                /* Linked Styles */
                body {
                  padding: 0 !important;
                  margin: 0 !important;
                  display: block !important;
                  min-width: 100% !important;
                  width: 100% !important;
                  background: #001736;
                  -webkit-text-size-adjust: none;
                }
                a {
                  color: #66c7ff;
                  text-decoration: none;
                }
                p {
                  padding: 0 !important;
                  margin: 0 !important;
                }
                img {
                  -ms-interpolation-mode: bicubic; /* Allow smoother rendering of resized image in Internet Explorer */
                }
                .mcnPreviewText {
                  display: none !important;
                }
          
                /* Mobile styles */
                @media only screen and (max-device-width: 480px),
                  only screen and (max-width: 480px) {
                  .mobile-shell {
                    width: 100% !important;
                    min-width: 100% !important;
                  }
          
                  .text-header,
                  .m-center {
                    text-align: center !important;
                  }
          
                  .center {
                    margin: 0 auto !important;
                  }
                  .container {
                    padding: 20px 10px !important;
                  }
          
                  .td {
                    width: 100% !important;
                    min-width: 100% !important;
                  }
          
                  .m-br-15 {
                    height: 15px !important;
                  }
                  .p30-15 {
                    padding: 30px 15px !important;
                  }
          
                  .m-td,
                  .m-hide {
                    display: none !important;
                    width: 0 !important;
                    height: 0 !important;
                    font-size: 0 !important;
                    line-height: 0 !important;
                    min-height: 0 !important;
                  }
          
                  .m-block {
                    display: block !important;
                  }
          
                  .fluid-img img {
                    width: 100% !important;
                    max-width: 100% !important;
                    height: auto !important;
                  }
          
                  .column,
                  .column-top,
                  .column-empty,
                  .column-empty2,
                  .column-dir-top {
                    float: left !important;
                    width: 100% !important;
                    display: block !important;
                  }
          
                  .column-empty {
                    padding-bottom: 10px !important;
                  }
                  .column-empty2 {
                    padding-bottom: 30px !important;
                  }
          
                  .content-spacing {
                    width: 15px !important;
                  }
                }
              </style>
            </head>
            <body
              class="body"
              style="
                padding: 0 !important;
                margin: 0 !important;
                display: block !important;
                min-width: 100% !important;
                width: 100% !important;
                background: #001736;
                -webkit-text-size-adjust: none;
              "
            >
              <table
                width="100%"
                border="0"
                cellspacing="0"
                cellpadding="0"
                bgcolor="#001736"
              >
                <tr>
                  <td align="center" valign="top">
                    <table
                      width="650"
                      border="0"
                      cellspacing="0"
                      cellpadding="0"
                      class="mobile-shell"
                    >
                      <tr>
                        <td
                          class="td container"
                          style="
                            width: 650px;
                            min-width: 650px;
                            font-size: 0pt;
                            line-height: 0pt;
                            margin: 0;
                            font-weight: normal;
                            padding: 55px 0px;
                          "
                        >
                          <!-- Header -->
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td class="p30-15" style="padding: 0px 30px 30px 30px">
                                <table
                                  width="100%"
                                  border="0"
                                  cellspacing="0"
                                  cellpadding="0"
                                >
                                  <tr>
                                    <th
                                      class="column-top"
                                      width="145"
                                      style="
                                        font-size: 0pt;
                                        line-height: 0pt;
                                        padding: 0;
                                        margin: 0;
                                        font-weight: normal;
                                        vertical-align: top;
                                      "
                                    >
                                      <table
                                        width="100%"
                                        border="0"
                                        cellspacing="0"
                                        cellpadding="0"
                                      >
                                        <tr>
                                          <td
                                            class="img m-center"
                                            style="
                                              font-size: 0pt;
                                              line-height: 0pt;
                                              text-align: left;
                                            "
                                          >
                                            <img
                                              src="https://i.pinimg.com/236x/71/b3/e4/71b3e4159892bb319292ab3b76900930.jpg"
                                              width="131"
                                              height="38"
                                              editable="true"
                                              border="0"
                                              alt=""
                                            />
                                          </td>
                                        </tr>
                                      </table>
                                    </th>
                                    <th
                                      class="column-empty"
                                      width="1"
                                      style="
                                        font-size: 0pt;
                                        line-height: 0pt;
                                        padding: 0;
                                        margin: 0;
                                        font-weight: normal;
                                        vertical-align: top;
                                      "
                                    ></th>
                                    <th
                                      class="column"
                                      style="
                                        font-size: 0pt;
                                        line-height: 0pt;
                                        padding: 0;
                                        margin: 0;
                                        font-weight: normal;
                                      "
                                    >
                                      <table
                                        width="100%"
                                        border="0"
                                        cellspacing="0"
                                        cellpadding="0"
                                      >
                                        <tr>
                                          <td
                                            class="text-header"
                                            style="
                                              color: #475c77;
                                              font-family: Arial, sans-serif;
                                              font-size: 12px;
                                              line-height: 16px;
                                              text-align: right;
                                            "
                                          >
                                            <multiline
                                              ><webversion
                                                class="link2"
                                                style="
                                                  color: #475c77;
                                                  text-decoration: none;
                                                "
                                                >Open in your browser</webversion
                                              ></multiline
                                            >
                                          </td>
                                        </tr>
                                      </table>
                                    </th>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                          </table>
                          <!-- END Header -->
          
                          <repeater>
                            <!-- Intro -->
                            <layout label="Intro">
                              <table
                                width="100%"
                                border="0"
                                cellspacing="0"
                                cellpadding="0"
                              >
                                <tr>
                                  <td style="padding-bottom: 10px">
                                    <table
                                      width="100%"
                                      border="0"
                                      cellspacing="0"
                                      cellpadding="0"
                                    >
                                      <tr>
                                        <td
                                          class="tbrr p30-15"
                                          style="
                                            padding: 60px 30px;
                                            border-radius: 26px 26px 0px 0px;
                                          "
                                          bgcolor="#12325c"
                                        >
                                          <table
                                            width="100%"
                                            border="0"
                                            cellspacing="0"
                                            cellpadding="0"
                                          >
                                            <tr>
                                              <td
                                                class="h1 pb25"
                                                style="
                                                  color: #ffffff;
                                                  font-family: Arial, sans-serif;
                                                  font-size: 40px;
                                                  line-height: 46px;
                                                  text-align: center;
                                                  padding-bottom: 25px;
                                                "
                                              >
                                                <multiline
                                                  >Welcome, Emily Garrett</multiline
                                                >
                                              </td>
                                            </tr>
                                            <tr>
                                              <td
                                                class="text-center pb25"
                                                style="
                                                  color: #c1cddc;
                                                  font-family: Arial, sans-serif;
                                                  font-size: 16px;
                                                  line-height: 30px;
                                                  text-align: center;
                                                  padding-bottom: 25px;
                                                "
                                              >
                                                <multiline
                                                  >Lorem ipsum dolor sit amet, consectetur
                                                  adipisicing elit, sed do eiusmod
                                                  <span class="m-hide"><br /></span>tempor
                                                  incididunt ut labore et dolore magna
                                                  aliqua.</multiline
                                                >
                                              </td>
                                            </tr>
                                            <!-- Button -->
                                            <tr>
                                              <td align="center">
                                                <table
                                                  class="center"
                                                  border="0"
                                                  cellspacing="0"
                                                  cellpadding="0"
                                                  style="text-align: center"
                                                >
                                                  <tr>
                                                    <td
                                                      class="pink-button text-button"
                                                      style="
                                                        background: #ff6666;
                                                        color: #c1cddc;
                                                        font-family: Arial,
                                                          sans-serif;
                                                        font-size: 14px;
                                                        line-height: 18px;
                                                        padding: 12px 30px;
                                                        text-align: center;
                                                        border-radius: 0px 22px 22px 22px;
                                                        font-weight: bold;
                                                      "
                                                    >
                                                      <multiline
                                                        ><a
                                                          href="#"
                                                          target="_blank"
                                                          class="link-white"
                                                          style="
                                                            color: #ffffff;
                                                            text-decoration: none;
                                                          "
                                                          ><span
                                                            class="link-white"
                                                            style="
                                                              color: #ffffff;
                                                              text-decoration: none;
                                                            "
                                                            >CLICK HERE</span
                                                          ></a
                                                        ></multiline
                                                      >
                                                    </td>
                                                  </tr>
                                                </table>
                                              </td>
                                            </tr>
                                            <!-- END Button -->
                                          </table>
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                              </table>
                            </layout>
                            <!-- END Intro -->
          
                            <!-- Article / Full Width Image + Title + Copy + Button -->
                            <layout
                              label="Article / Full Width Image + Title + Copy + Button"
                            >
                              <table
                                width="100%"
                                border="0"
                                cellspacing="0"
                                cellpadding="0"
                              >
                                <tr>
                                  <td style="padding-bottom: 10px">
                                    <table
                                      width="100%"
                                      border="0"
                                      cellspacing="0"
                                      cellpadding="0"
                                      bgcolor="#0e264b"
                                    >
                                      <tr>
                                        <td
                                          class="fluid-img"
                                          style="
                                            font-size: 0pt;
                                            line-height: 0pt;
                                            text-align: left;
                                          "
                                        >
                                          <img
                                            src="https://www.marketing91.com/wp-content/uploads/2019/07/Importance-of-Corporate-Image.jpg"
                                            width="650"
                                            height="366"
                                            editable="true"
                                            border="0"
                                            alt=""
                                          />
                                        </td>
                                      </tr>
                                      <tr>
                                        <td class="p30-15" style="padding: 50px 30px">
                                          <table
                                            width="100%"
                                            border="0"
                                            cellspacing="0"
                                            cellpadding="0"
                                          >
                                            <tr>
                                              <td
                                                class="h3 pb20"
                                                style="
                                                  color: #ffffff;
                                                  font-family: Arial, sans-serif;
                                                  font-size: 25px;
                                                  line-height: 32px;
                                                  text-align: left;
                                                  padding-bottom: 20px;
                                                "
                                              >
                                                <multiline
                                                  >Lorem ipsum dolor sit amet</multiline
                                                >
                                              </td>
                                            </tr>
                                            <tr>
                                              <td
                                                class="text pb20"
                                                style="
                                                  color: #ffffff;
                                                  font-family: Arial, sans-serif;
                                                  font-size: 14px;
                                                  line-height: 26px;
                                                  text-align: left;
                                                  padding-bottom: 20px;
                                                "
                                              >
                                                <multiline
                                                  >Lorem ipsum dolor sit amet, consectetur
                                                  adipisicing elit, sed do eiusmod tempor
                                                  incididunt ut labore et dolore magna
                                                  aliqua. Ut enim ad minim veniam, quis
                                                  nostrud exercitation ullamco laboris
                                                  nisi ut aliquip ex ea commodo
                                                  consequat.</multiline
                                                >
                                              </td>
                                            </tr>
                                            <!-- Button -->
                                            <tr>
                                              <td align="left">
                                                <table
                                                  border="0"
                                                  cellspacing="0"
                                                  cellpadding="0"
                                                >
                                                  <tr>
                                                    <td
                                                      class="blue-button text-button"
                                                      style="
                                                        background: #66c7ff;
                                                        color: #c1cddc;
                                                        font-family: Arial,
                                                          sans-serif;
                                                        font-size: 14px;
                                                        line-height: 18px;
                                                        padding: 12px 30px;
                                                        text-align: center;
                                                        border-radius: 0px 22px 22px 22px;
                                                        font-weight: bold;
                                                      "
                                                    >
                                                      <multiline
                                                        ><a
                                                          href="#"
                                                          target="_blank"
                                                          class="link-white"
                                                          style="
                                                            color: #ffffff;
                                                            text-decoration: none;
                                                          "
                                                          ><span
                                                            class="link-white"
                                                            style="
                                                              color: #ffffff;
                                                              text-decoration: none;
                                                            "
                                                            >CLICK HERE</span
                                                          ></a
                                                        ></multiline
                                                      >
                                                    </td>
                                                  </tr>
                                                </table>
                                              </td>
                                            </tr>
                                            <!-- END Button -->
                                          </table>
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                              </table>
                            </layout>
                            <!-- END Article / Full Width Image + Title + Copy + Button -->
                            
                          <!-- Footer -->
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td
                                class="p30-15 bbrr"
                                style="
                                  padding: 50px 30px;
                                  border-radius: 0px 0px 26px 26px;
                                "
                                bgcolor="#0e264b"
                              >
                                <table
                                  width="100%"
                                  border="0"
                                  cellspacing="0"
                                  cellpadding="0"
                                >
                                  <tr>
                                    <td align="center" style="padding-bottom: 30px">
                                      <table border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td
                                            class="img"
                                            width="55"
                                            style="
                                              font-size: 0pt;
                                              line-height: 0pt;
                                              text-align: left;
                                            "
                                          >
                                            <a href="#" target="_blank"
                                              ><img
                                                src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/Facebook_icon.svg/1200px-Facebook_icon.svg.png"
                                                width="38"
                                                height="38"
                                                editable="true"
                                                border="0"
                                                alt=""
                                            /></a>
                                          </td>
                                          <td
                                            class="img"
                                            width="55"
                                            style="
                                              font-size: 0pt;
                                              line-height: 0pt;
                                              text-align: left;
                                            "
                                          >
                                            <a href="#" target="_blank"
                                              ><img
                                                src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a5/Instagram_icon.png/2048px-Instagram_icon.png"
                                                width="38"
                                                height="38"
                                                editable="true"
                                                border="0"
                                                alt=""
                                            /></a>
                                          </td>
                                          <td
                                            class="img"
                                            width="55"
                                            style="
                                              font-size: 0pt;
                                              line-height: 0pt;
                                              text-align: left;
                                            "
                                          >
                                            <a href="#" target="_blank"
                                              ><img
                                                src="https://assets.stickpng.com/images/58e9196deb97430e819064f6.png"
                                                width="38"
                                                height="38"
                                                editable="true"
                                                border="0"
                                                alt=""
                                            /></a>
                                          </td>
                                          <td
                                            class="img"
                                            width="38"
                                            style="
                                              font-size: 0pt;
                                              line-height: 0pt;
                                              text-align: left;
                                            "
                                          >
                                            <a href="#" target="_blank"
                                              ><img
                                                src="https://cdn.worldvectorlogo.com/logos/linkedin-icon-2.svg"
                                                width="38"
                                                height="38"
                                                editable="true"
                                                border="0"
                                                alt=""
                                            /></a>
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="text-footer1 pb10"
                                      style="
                                        color: #c1cddc;
                                        font-family:Arial, sans-serif;
                                        font-size: 16px;
                                        line-height: 20px;
                                        text-align: center;
                                        padding-bottom: 10px;
                                      "
                                    >
                                      <multiline
                                        >Bussy - Free HTML Email Template</multiline
                                      >
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="text-footer2"
                                      style="
                                        color: #8297b3;
                                        font-family: Arial, sans-serif;
                                        font-size: 12px;
                                        line-height: 26px;
                                        text-align: center;
                                      "
                                    >
                                      <multiline
                                        >East Pixel Bld. 99, Creative City 9000,
                                        <br />Republic of Design</multiline
                                      >
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                            <tr>
                              <td
                                class="text-footer3 p30-15"
                                style="
                                  padding: 40px 30px 0px 30px;
                                  color: #475c77;
                                  font-family: Arial, sans-serif;
                                  font-size: 12px;
                                  line-height: 18px;
                                  text-align: center;
                                "
                              >
                                <unsubscribe
                                  class="link2-u"
                                  style="color: #475c77; text-decoration: underline"
                                  >Unsubscribe from this mailing list.</unsubscribe
                                >
                              </td>
                            </tr>
                          </table>
                          <!-- END Footer -->
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </body>
          </html>
          ',
          'status' => "1",
      ]);

      DB::table("mail_templates")->insert([
        'id' => '4',
        'agency_id' => '1',
        'client_id' => '1',
        'user_id' => '1',
        'name' => 'Admin Notification Mail',
        'slug' => 'notifyadmin',
        'subject' => 'some sample subject',
        'message' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
          <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
          <meta name="viewport" content="width=device-width, initial-scale=1" />
          <title>Skyline Ping Email</title>
          <style type="text/css">
            @import url(http://fonts.googleapis.com/css?family=Lato:400);
        
            /* Take care of image borders and formatting */
        
            img {
              max-width: 600px;
              outline: none;
              text-decoration: none;
              -ms-interpolation-mode: bicubic;
            }
        
            a {
              text-decoration: none;
              border: 0;
              outline: none;
              color: #21BEB4;
            }
        
            a img {
              border: none;
            }
        
            /* General styling */
        
            td, h1, h2, h3  {
              font-family: Helvetica, Arial, sans-serif;
              font-weight: 400;
            }
        
            body {
              -webkit-font-smoothing:antialiased;
              -webkit-text-size-adjust:none;
              width: 100%;
              height: 100%;
              color: #37302d;
              background: #ffffff;
            }
        
            table {
              background:
            }
        
            h1, h2, h3 {
              padding: 0;
              margin: 0;
              color: #ffffff;
              font-weight: 400;
            }
        
            h3 {
              color: #21c5ba;
              font-size: 24px;
            }
          </style>
        
          <style type="text/css" media="screen">
            @media screen {
               /* Thanks Outlook 2013! http://goo.gl/XLxpyl*/
              td, h1, h2, h3 {
                font-family: !important;
              }
            }
          </style>
        
          <style type="text/css" media="only screen and (max-width: 480px)">
            /* Mobile styles */
            @media only screen and (max-width: 480px) {
              table[class="w320"] {
                width: 320px !important;
              }
        
              table[class="w300"] {
                width: 300px !important;
              }
        
              table[class="w290"] {
                width: 290px !important;
              }
        
              td[class="w320"] {
                width: 320px !important;
              }
        
              td[class="mobile-center"] {
                text-align: center !important;
              }
        
              td[class="mobile-padding"] {
                padding-left: 20px !important;
                padding-right: 20px !important;
                padding-bottom: 20px !important;
              }
            }
          </style>
        </head>
        <body class="body" style="padding:0; margin:0; display:block; background:#ffffff; -webkit-text-size-adjust:none" bgcolor="#ffffff">
        <table align="center" cellpadding="0" cellspacing="0" width="100%" height="100%" >
          <tr>
            <td align="center" valign="top" bgcolor="#ffffff"  width="100%">
        
            <table cellspacing="0" cellpadding="0" width="100%">
              <tr>
                <td style="border-bottom: 3px solid #3bcdc3;" width="100%">
                  <center>
                    <table cellspacing="0" cellpadding="0" width="500" class="w320">
                      <tr>
                        <td valign="top" style="padding:10px 0; text-align:left;" class="mobile-center">
                          <img width="250" height="62" src="https://www.filepicker.io/api/file/TtSuN5UdTmO0NXWPfYCJ">
                        </td>
                      </tr>
                    </table>
                  </center>
                </td>
              </tr>
              <tr>
                <td background="https://www.filepicker.io/api/file/zLBr1W6UT6qZP4jI2yRz" bgcolor="#64594b" valign="top" style="background: url(https://www.filepicker.io/api/file/zLBr1W6UT6qZP4jI2yRz) no-repeat center; background-color: #64594b; background-position: center;">
                  <!--[if gte mso 9]>
                  <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:1000;height:303px;">
                    <v:fill type="tile" src="https://www.filepicker.io/api/file/ewEXNrLlTneFGtlB5ryy" color="#64594b" />
                    <v:textbox inset="0,0,0,0">
                  <![endif]-->
                  <div>
                    <center>
                      <table cellspacing="0" cellpadding="0" width="530" height="303" class="w320">
                        <tr>
                          <td valign="middle" style="vertical-align:middle; padding-right: 15px; padding-left: 15px; text-align:left;" class="mobile-center" height="303">
        
                            <h1>UPDATE!</h1>
                            <h2>Your account settings have been updated</h2>
        
                          </td>
                        </tr>
                      </table>
                    </center>
                  </div>
                  <!--[if gte mso 9]>
                    </v:textbox>
                  </v:rect>
                  <![endif]-->
                </td>
              </tr>
              <tr>
                <td valign="top">
                  <center>
                    <table cellspacing="0" cellpadding="0" width="500" class="w320">
                      <tr>
                        <td>
        
                          <table cellspacing="0" cellpadding="0" width="100%">
                            <tr>
                              <td class="mobile-padding" style="text-align:left;">
                              <br>
                              <br>
                                Hi {{ first_name }},<br><br>
                                Your account settings have been updated. If you did not update your settings, please <a href="#">contact support</a>
                                <br>
        
                                <br>
                                Thanks for being a customer!<br>
                                Awesome Inc
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td class="mobile-padding">
                        <br>
                        <br>
                          <table cellspacing="0" cellpadding="0" width="100%">
                            <tr>
                              <td style="width:200px; background-color: #3bcdc3;">
                                <div><!--[if mso]>
                                    <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="#" style="height:33px;v-text-anchor:middle;width:200px;" arcsize="8%" stroke="f" fillcolor="#3bcdc3">
                                      <w:anchorlock/>
                                      <center style="color:#ffffff;font-family:sans-serif;font-size:13px;">Review Account Settings</center>
                                    </v:roundrect>
                                  <![endif]-->
                                  <!--[if !mso]><!-- --><a href="#"><table cellspacing="0" cellpadding="0" width="100%"><tr><td style="background-color:#3bcdc3;border-radius:0px;color:#ffffff;display:inline-block; Helvetica, Arial, sans-serif;font-weight:bold;font-size:13px;line-height:33px;text-align:center;text-decoration:none;width:200px;-webkit-text-size-adjust:none;mso-hide:all;"><span style="color:#ffffff">Review Account Settings</span></td></tr></table></a>
                                  <!--<![endif]-->
                                </div>
                              </td>
                              <td>
                                &nbsp;
                              </td>
                            </tr>
                          </table>
                          <br>&nbsp;
                          <br>
                        </td>
                      </tr>
                    </table>
                  </center>
                </td>
              </tr>
              <tr>
                <td style="background-color:#c2c2c2;">
                  <center>
                    <table cellspacing="0" cellpadding="0" width="500" class="w320">
                      <tr>
                        <td>
                          <table cellspacing="0" cellpadding="30" width="100%">
                            <tr>
                              <td style="text-align:center;">
                                <a href="#">
                                  <img width="61" height="51" src="https://www.filepicker.io/api/file/vkoOlof0QX6YCDF9cCFV" alt="twitter" />
                                </a>
                                <a href="#">
                                  <img width="61" height="51" src="https://www.filepicker.io/api/file/fZaNDx7cSPaE23OX2LbB" alt="google plus" />
                                </a>
                                <a href="#">
                                  <img width="61" height="51" src="https://www.filepicker.io/api/file/b3iHzECrTvCPEAcpRKPp" alt="facebook" />
                                </a>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <center>
                            <table style="margin:0 auto;" cellspacing="0" cellpadding="5" width="100%">
                              <tr>
                                <td style="text-align:center; margin:0 auto;" width="100%">
                                   <a href="#" style="text-align:center;">
                                     <img style="margin:0 auto;" width="123" height="24" src="https://www.filepicker.io/api/file/u7CkMXcOSlG8TMbr3LnG" alt="logo link" />
                                   </a>
                                </td>
                              </tr>
                            </table>
                          </center>
                        </td>
                      </tr>
                    </table>
                  </center>
                </td>
              </tr>
            </table>
            </td>
          </tr>
        </table>
        </body>
        </html>',
        'status' => "1",
    ]);
        
    }
}
