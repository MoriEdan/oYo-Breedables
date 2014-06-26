//start_unprocessed_text
/*/|/ ----------------------------------------------------------------------------------
/|/ Database Test "Birth" Script V1.00
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
string HTTP_BIRTH_PHP   = "index.php?option=com_breedable&view=configuration&task=configuration.birth";

string TXT_BREED         = "oYo Horses";

/|/ test data
string fath_name         = "Romeo";
string fath_config         = "oYo Horses-BlackWalker-Amber-1401528763-male-100-100-0-10-1-1-1-0-Grandfather-Grandmother-B1-0-0-0-0";

string moth_name         = "Giulia";
string moth_config         = "oYo Horses-WhiteArab-Crimson-1401528763-female-100-100-0-10-1-1-1-0-Grandfather-Grandmother-B2-0-0-2-0";

/|/ status
/|/string status = "A";

/|/ status
string grandfather_status = "Born";
string grandmother_status = "Born";
string previous_status = "Born";
string current_status = "Birth";

/|/ internal use
key http_request_id = NULL_KEY;

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

integer get_id(string line)
{
    list tokens = llParseString2List(line, ["-"], []);
    if (TXT_BREED == llList2String(tokens, 0))
        return llList2Integer(tokens, 19);
    else
        return 0;
}

send_birth()
{
    string url = HTTP_HOSTNAME + HTTP_BIRTH_PHP; 
    url += "&owner_name="             + llEscapeURL(llKey2Name(llGetOwner()));
    url += "&owner_key="              + (string) llGetOwner();
    url += "&breedable_type="         + llEscapeURL(TXT_BREED);
    url += "&breedable_name="         + llGetObjectName();
    url += "&father_name="     + llEscapeURL(fath_name);
    /|/url += "&father_id="         + (string) get_id(fath_config);
    url += "&father_config="     + llEscapeURL(fath_config);
    url += "&mother_name="     + llEscapeURL(moth_name);
    /|/url += "&mother_id="         + (string) get_id(moth_config);
    url += "&mother_config="     + llEscapeURL(moth_config);
    url += "&generation="   + (string) (get_generation(moth_config) + 1);
    url += "&grandfather_status="     + llEscapeURL(grandfather_status);
    url += "&grandmother_status="     + llEscapeURL(grandmother_status);
    url += "&previous_status="     + llEscapeURL(previous_status);
    url += "&current_status="     + llEscapeURL(current_status);
    
    
    
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
        send_birth();
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
/|/ ----------------------------------------------------------------------------------*/
//end_unprocessed_text
//nfo_preprocessor_version 0
//program_version DarkStorm v3.0.2 <Firestorm-Release v4.5.1.38838> - Revolution Perenti
//mono


string previous_status = "Born";
string moth_name         = "Giulia";
string moth_config         = "oYo Horses-WhiteArab-Crimson-1401528763-female-100-100-0-10-1-1-1-0-Grandfather-Grandmother-B2-0-0-2-0";
key http_request_id = NULL_KEY;
string grandmother_status = "Born";
string grandfather_status = "Born";
string fath_name         = "Romeo";
string fath_config         = "oYo Horses-BlackWalker-Amber-1401528763-male-100-100-0-10-1-1-1-0-Grandfather-Grandmother-B1-0-0-0-0";
string current_status = "Birth";
string TXT_BREED         = "oYo Horses";
string HTTP_HOSTNAME     = "http://oyobreedables.com/";
string HTTP_BIRTH_PHP   = "index.php?option=com_breedable&view=configuration&task=configuration.birth";
integer DEBUG           = TRUE;
integer get_generation(string line)
{
    list tokens = llParseString2List(line, ["-"], []);
    if (TXT_BREED == llList2String(tokens, 0))
        return llList2Integer(tokens, 18);
    else
        return 0;
}






send_birth()
{
    string url = HTTP_HOSTNAME + HTTP_BIRTH_PHP; 
    url += "&owner_name="             + llEscapeURL(llKey2Name(llGetOwner()));
    url += "&owner_key="              + (string) llGetOwner();
    url += "&breedable_type="         + llEscapeURL(TXT_BREED);
    url += "&breedable_name="         + llGetObjectName();
    url += "&father_name="     + llEscapeURL(fath_name);
    
    url += "&father_config="     + llEscapeURL(fath_config);
    url += "&mother_name="     + llEscapeURL(moth_name);
    
    url += "&mother_config="     + llEscapeURL(moth_config);
    url += "&generation="   + (string) (get_generation(moth_config) + 1);
    url += "&grandfather_status="     + llEscapeURL(grandfather_status);
    url += "&grandmother_status="     + llEscapeURL(grandmother_status);
    url += "&previous_status="     + llEscapeURL(previous_status);
    url += "&current_status="     + llEscapeURL(current_status);
    
    
    
    
    url += "&format="     + llEscapeURL("raw");
    
    log("request: " + url + " (" + (string) llStringLength(url) + " char)");

    
    http_request_id = llHTTPRequest(url, [HTTP_METHOD, "GET"], "");
}


log(string message)
{
    if (DEBUG) llOwnerSay(message);
}


display_result(string body)
{
    llSay(0, body);
}


default
{
    touch_start(integer total_number)
    {
        send_birth();
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