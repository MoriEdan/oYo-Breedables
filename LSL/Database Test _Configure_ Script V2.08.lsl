// ----------------------------------------------------------------------------------
// Database Test "Configure" Script V1.00
// ----------------------------------------------------------------------------------
// Copyright (c) 2014, Jenni Eales. All rights reserved.
// ----------------------------------------------------------------------------------
// Changes:
// ----------------------------------------------------------------------------------
// Version 1.0
// - first version released
// ----------------------------------------------------------------------------------
//
// constants
integer DEBUG           = TRUE;
string HTTP_HOSTNAME     = "http://oyobreedables.com/";
string HTTP_CONFIG_PHP    = "index.php?option=com_breedable&view=configuration&task=configuration.configure";

string TXT_BREED         = "oYo Horses";

// internal use
key http_request_id = NULL_KEY;

// status
string sibling_status = "C";
string delivered_status = "Delivered";


log(string message)
{
    if (DEBUG) llOwnerSay(message);
}

retrieve_configuration(string mode)
{
    string url = HTTP_HOSTNAME + HTTP_CONFIG_PHP; 
    url += "&owner_name="         + llEscapeURL(llKey2Name(llGetOwner()));
    url += "&owner_key="          + (string) llGetOwner();
    url += "&breedable_type="     + llEscapeURL(TXT_BREED);
    url += "&sibling_status="     + llEscapeURL(sibling_status);
    url += "&delivered_status="     + llEscapeURL(delivered_status);
    //url += "&status="     + llEscapeURL(status);
    
    // configure mode
    url += "&mode="             + llEscapeURL(mode);

    // output raw
    url += "&format="             + llEscapeURL("raw");
    
    log("request: " + url + " (" + (string) llStringLength(url) + " char)");

    // send request
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
        // modes: father, mother, sibling
        retrieve_configuration("sibling");
    }

    // answer of http response
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

// ----------------------------------------------------------------------------------
// Redistribution and use in source and binary forms, with or without modification,
// are permitted provided that the following conditions are met:
//
//    * Redistributions of source code must retain the above copyright notice,
//      this list of conditions and the following disclaimer.
//    * Redistributions in binary form must reproduce the above copyright notice,
//      this list of conditions and the following disclaimer in the documentation
//      and/or other materials provided with the distribution.
//    * The names of its contributors may not be used to endorse or promote products
//      derived from this software without specific prior written permission.
//
// THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY
// EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES
// OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
// IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT,
// INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
// BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA,
// OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY,
// WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
// ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY
// OF SUCH DAMAGE.
// ----------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------
// Database Test "Configure" Script V1.00
// ----------------------------------------------------------------------------------
// Copyright (c) 2014, Jenni Eales. All rights reserved.
// ----------------------------------------------------------------------------------
// Changes:
// ----------------------------------------------------------------------------------
// Version 1.0
// - first version released
// ----------------------------------------------------------------------------------
//
// constants
integer DEBUG           = TRUE;
string HTTP_HOSTNAME     = "http://oyobreedables.com/";
string HTTP_CONFIG_PHP    = "index.php?option=com_breedable&view=configuration&task=configuration.configure";

string TXT_BREED         = "oYo Horses";

// internal use
key http_request_id = NULL_KEY;

// status
string sibling_status = "C";
string delivered_status = "Delivered";


log(string message)
{
    if (DEBUG) llOwnerSay(message);
}

retrieve_configuration(string mode)
{
    string url = HTTP_HOSTNAME + HTTP_CONFIG_PHP; 
    url += "&owner_name="         + llEscapeURL(llKey2Name(llGetOwner()));
    url += "&owner_key="          + (string) llGetOwner();
    url += "&breedable_type="     + llEscapeURL(TXT_BREED);
    url += "&sibling_status="     + llEscapeURL(sibling_status);
    url += "&delivered_status="     + llEscapeURL(delivered_status);
    //url += "&status="     + llEscapeURL(status);
    
    // configure mode
    url += "&mode="             + llEscapeURL(mode);

    // output raw
    url += "&format="             + llEscapeURL("raw");
    
    log("request: " + url + " (" + (string) llStringLength(url) + " char)");

    // send request
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
        // modes: father, mother, sibling
        retrieve_configuration("sibling");
    }

    // answer of http response
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

// ----------------------------------------------------------------------------------
// Redistribution and use in source and binary forms, with or without modification,
// are permitted provided that the following conditions are met:
//
//    * Redistributions of source code must retain the above copyright notice,
//      this list of conditions and the following disclaimer.
//    * Redistributions in binary form must reproduce the above copyright notice,
//      this list of conditions and the following disclaimer in the documentation
//      and/or other materials provided with the distribution.
//    * The names of its contributors may not be used to endorse or promote products
//      derived from this software without specific prior written permission.
//
// THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY
// EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES
// OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
// IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT,
// INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
// BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA,
// OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY,
// WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
// ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY
// OF SUCH DAMAGE.
// ----------------------------------------------------------------------------------
