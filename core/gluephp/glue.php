<?php
/*
URL handler

Author (modifier): Mathias Beke
Url: http://denbeke.be
Date: March 2014


This is a modified version of GluePHP.
GluePHP was originally created by Joe Topjian and can be found at gluephp.com


Copyright (c) 2012, Joe Topjian
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:
    * Redistributions of source code must retain the above copyright
      notice, this list of conditions and the following disclaimer.
    * Redistributions in binary form must reproduce the above copyright
      notice, this list of conditions and the following disclaimer in the
      documentation and/or other materials provided with the distribution.
    * Neither the name of Joe Topjian nor the
      names of its contributors may be used to endorse or promote products
      derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL JOE TOPJIAN BE LIABLE FOR ANY
(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

    /**
     * glue
     *
     * Provides an easy way to map URLs to classes. URLs can be literal
     * strings or regular expressions.
     *
     * When the URLs are processed:
     *      * delimiter (/) are automatically escaped: (\/)
     *      * The beginning and end are anchored (^ $)
     *      * An optional end slash is added (/?)
     *      * The i option is added for case-insensitive searches
     *
     * Example:
     *
     * $urls = array(
     *     '/' => 'index',
     *     '/page/(\d+)' => 'page'
     * );
     *
     * class page {
     *      function GET($matches) {
     *          echo "Your requested page " . $matches[1];
     *      }
     * }
     *
     * glue::stick($urls);
     *
     */
    class glue {

        /**
         * stick
         *
         * the main static function of the glue class.
         *
         * @param   array       $urls       The regex-based url to class mapping
         * @throws  Exception               Thrown if corresponding class is not found
         * @throws  Exception               Thrown if no match is found
         * @throws  BadMethodCallException  Thrown if a corresponding GET,POST is not found
         *
         */
        static function stick ($urls) {

            $method = strtoupper($_SERVER['REQUEST_METHOD']);
            $path = $_SERVER['REQUEST_URI'];

            $found = false;

            krsort($urls);

            foreach ($urls as $regex => $class) {
                $regex = str_replace('/', '\/', $regex);
                $regex = '^' . $regex . '\/?$';
                if (preg_match("/$regex/i", $path, $matches)) {
                    $found = true;
                    if (class_exists($class)) {
                        $obj = new $class;
                        if (method_exists($obj, 'GET')) {
                            $obj->GET($matches);
                        }
                        else {
                            throw new BadMethodCallException("Method, $method, not supported.");
                        }
                        if($method == 'POST') {
                            if (method_exists($obj, $method)) {
                                $obj->$method($matches);
                            }
                            else {
                                throw new BadMethodCallException("Method, $method, not supported.");
                            }
                        }
                        return $obj;
                    } else {
                        throw new Exception("Class, $class, not found.");
                    }
                    break;
                }
            }
            if (!$found) {

                foreach ($urls as $regex => $class) {
                    if($regex == 'ERROR') {
                        if (class_exists($class)) {
                            $obj = new $class;
                            if (method_exists($obj, $method)) {
                                $obj->$method($matches);
                                return $obj;
                            } else {
                                throw new BadMethodCallException("Method, $method, not supported.");
                            }
                        } else {
                            throw new Exception("Class, $class, not found.");
                        }
                        break;
                    }
                }

                throw new Exception("URL, $path, not found.");
            }
        }
    }
