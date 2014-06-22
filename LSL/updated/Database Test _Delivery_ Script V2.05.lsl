//start_unprocessed_text
/*/|/ ----------------------------------------------------------------------------------
/|/ Database Test "Delivery" Script V1.00
/|/ ----------------------------------------------------------------------------------
/|/ Copyright (c) 2014, Jenni Eales. All rights reserved.
/|/ ----------------------------------------------------------------------------------
/|/ Changes:
/|/ ----------------------------------------------------------------------------------
/|/ Version 1.0
/|/ - first version released
/|/ ----------------------------------------------------------------------------------
/|/
/|/ constants
integer DEBUG           = TRUE;
string HTTP_HOSTNAME     = "http:/|/oyobreedables.com/";
string HTTP_DELIVERY_PHP = "index.php?option=com_breedable&view=configuration&task=configuration.delivery";

string TXT_BREED         = "oYo Horses";

string status = "B";
/|/ internal use
key http_request_id = NULL_KEY;

log(string message)
{
    if (DEBUG) llOwnerSay(message);
}

check_delivery()
{
    string url = HTTP_HOSTNAME + HTTP_DELIVERY_PHP;
    url += "&breedable_type="         + llEscapeURL(TXT_BREED);
    url += "&owner_name="             + llEscapeURL(llKey2Name(llGetOwner()));
    url += "&owner_key="              + (string) llGetOwner();
    url += "&status="              + llEscapeURL(status);
    
    /|/ output raw
    url += "&format="     + llEscapeURL("raw");
 
    log("request: " + url + " (" + (string) llStringLength(url) + " char)");

    /|/ send request
    http_request_id = llHTTPRequest(url, [HTTP_METHOD, "GET"], "");
}

display_result(string body)
{
    llSay(0, body);
}

default
{
    touch_start(integer total_number)
    {
        check_delivery();
    }

    /|/ answer of http response
    http_response(key request_id, integer status, list metadata, string body)
    {
        if(http_request_id == request_id)
        {
            log("status: " + (string) status);
            if (status == 400)
                log("Bad Request");            
            if (status == 401)
                log("Unauthorized");            
            if (status == 403)
                log("Forbidden");            
            if (status == 404)
                log("Page not found");            
            else if (status == 500)
                log("Service not available");
            else if (status >= 300)
                log("Unknown error: " + (string) status);
            else
                display_result(body);            
        }
    }
}

/|/ ----------------------------------------------------------------------------------
/|/ Redistribution and use in source and binary forms, with or without modification,
/|/ are permitted provided that the following conditions are met:
/|/
/|/    * Redistributions of source code must retain the above copyright notice,
/|/      this list of conditions and the following disclaimer.
/|/    * Redistributions in binary form must reproduce the above copyright notice,
/|/      this list of conditions and the following disclaimer in the documentation
/|/      and/or other materials provided with the distribution.
/|/    * The names of its contributors may not be used to endorse or promote products
/|/      derived from this software without specific prior written permission.
/|/
/|/ THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY
/|/ EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES
/|/ OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
/|/ IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT,
/|/ INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
/|/ BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA,
/|/ OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY,
/|/ WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
/|/ ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY
/|/ OF SUCH DAMAGE.
/|/ ----------------------------------------------------------------------------------
*/
//end_unprocessed_text
//nfo_preprocessor_version 0
//program_version DarkStorm v3.0.2 <Firestorm-Release v4.5.1.38838> - Revolution Perenti
//mono


string status = "B";
key http_request_id = NULL_KEY;
string TXT_BREED         = "oYo Horses";
string HTTP_HOSTNAME     = "http://oyobreedables.com/";
string HTTP_DELIVERY_PHP = "index.php?option=com_breedable&view=configuration&task=configuration.delivery";
integer DEBUG           = TRUE;


log(string message)
{
    if (DEBUG) llOwnerSay(message);
}


display_result(string body)
{
    llSay(0, body);
}


check_delivery()
{
    string url = HTTP_HOSTNAME + HTTP_DELIVERY_PHP;
    url += "&breedable_type="         + llEscapeURL(TXT_BREED);
    url += "&owner_name="             + llEscapeURL(llKey2Name(llGetOwner()));
    url += "&owner_key="              + (string) llGetOwner();
    url += "&status="              + llEscapeURL(status);
    
    
    url += "&format="     + llEscapeURL("raw");
 
    log("request: " + url + " (" + (string) llStringLength(url) + " char)");

    
    http_request_id = llHTTPRequest(url, [HTTP_METHOD, "GET"], "");
}


default
{
    touch_start(integer total_number)
    {
        check_delivery();
    }

    
    http_response(key request_id, integer status, list metadata, string body)
    {
        if(http_request_id == request_id)
        {
            log("status: " + (string) status);
            if (status == 400)
                log("Bad Request");            
            if (status == 401)
                log("Unauthorized");            
            if (status == 403)
                log("Forbidden");            
            if (status == 404)
                log("Page not found");            
            else if (status == 500)
                log("Service not available");
            else if (status >= 300)
                log("Unknown error: " + (string) status);
            else
                display_result(body);            
        }
    }
}

























