// ----------------------------------------------------------------------------------
// Database Test "Register" Script V2.06
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
string HTTP_STARTER_PHP    = "index.php?option=com_breedable&view=configuration&task=configuration.register";

string TXT_BREED         = "oYo Horses";

// test data
//string name             = "Ramazotti";
//string config             = "oyo-BlackWalker-Amber-1401528763-M-100-100-0-10-1-1-1-0-Romeo (Starter)-Giulia (Starter)-B1-0-0-0-0";

// internal use
key http_request_id = NULL_KEY;

string TXT_STATUS = "Born";

log(string message)
{
    if (DEBUG) llOwnerSay(message);
}

integer get_generation(string line)
{
    list tokens = llParseString2List(line, ["-"], []);
    if (TXT_BREED == llList2String(tokens, 0))
        return llList2Integer(tokens, 18);
    else
        return 0;
}

string getLocation()
{
    vector pos = llGetPos();
    return llGetRegionName() + " (" + (string) llRound(pos.x) + ", " + (string) llRound(pos.y) + ", " + (string) llRound(pos.z) + ")";
}

register(string name, string config)
{
    string url = HTTP_HOSTNAME + HTTP_STARTER_PHP; 
    url += "&owner_name="             + llEscapeURL(llKey2Name(llGetOwner()));
    url += "&owner_key="              + (string) llGetOwner();
    url += "&breedable_type="         + llEscapeURL(TXT_BREED);
    url += "&breedable_name="         + llEscapeURL(name);
    url += "&breedable_config="       + llEscapeURL(config);
    url += "&location="               + llEscapeURL(getLocation());
    url += "&generation="             + (string) get_generation(config);
    url += "&status="                 + (string) llEscapeURL(TXT_STATUS);

    // output raw
    url += "&format="             + llEscapeURL("raw");

    log("request: " + url + " (" + (string) llStringLength(url) + " char)");

    llSay(0, "Generation = " + (string) get_generation(config));

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
        register(llGetObjectName(), llGetObjectDesc());
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
