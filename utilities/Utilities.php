<?php
    class Utilities {

        /**
         * Returns a string with all spaces converted to underscores (by default), accented
         * characters converted to non-accented characters, and non word characters removed.
         *
         * @param string $string the string you want to slug
         * @param string $replacement will replace keys in map
         * @return string
         */
        public static function slug($string, $replacement = '_') {
            $transliteration = [
                '/À|Á|Â|Ã|Å|Ǻ|Ā|Ă|Ą|Ǎ/' => 'A',
                '/Æ|Ǽ/' => 'AE',
                '/Ä/' => 'Ae',
                '/Ç|Ć|Ĉ|Ċ|Č/' => 'C',
                '/Ð|Ď|Đ/' => 'D',
                '/È|É|Ê|Ë|Ē|Ĕ|Ė|Ę|Ě/' => 'E',
                '/Ĝ|Ğ|Ġ|Ģ|Ґ/' => 'G',
                '/Ĥ|Ħ/' => 'H',
                '/Ì|Í|Î|Ï|Ĩ|Ī|Ĭ|Ǐ|Į|İ|І/' => 'I',
                '/Ĳ/' => 'IJ',
                '/Ĵ/' => 'J',
                '/Ķ/' => 'K',
                '/Ĺ|Ļ|Ľ|Ŀ|Ł/' => 'L',
                '/Ñ|Ń|Ņ|Ň/' => 'N',
                '/Ò|Ó|Ô|Õ|Ō|Ŏ|Ǒ|Ő|Ơ|Ø|Ǿ/' => 'O',
                '/Œ/' => 'OE',
                '/Ö/' => 'Oe',
                '/Ŕ|Ŗ|Ř/' => 'R',
                '/Ś|Ŝ|Ş|Ș|Š/' => 'S',
                '/ẞ/' => 'SS',
                '/Ţ|Ț|Ť|Ŧ/' => 'T',
                '/Þ/' => 'TH',
                '/Ù|Ú|Û|Ũ|Ū|Ŭ|Ů|Ű|Ų|Ư|Ǔ|Ǖ|Ǘ|Ǚ|Ǜ/' => 'U',
                '/Ü/' => 'Ue',
                '/Ŵ/' => 'W',
                '/Ý|Ÿ|Ŷ/' => 'Y',
                '/Є/' => 'Ye',
                '/Ї/' => 'Yi',
                '/Ź|Ż|Ž/' => 'Z',
                '/à|á|â|ã|å|ǻ|ā|ă|ą|ǎ|ª/' => 'a',
                '/ä|æ|ǽ/' => 'ae',
                '/ç|ć|ĉ|ċ|č/' => 'c',
                '/ð|ď|đ/' => 'd',
                '/è|é|ê|ë|ē|ĕ|ė|ę|ě/' => 'e',
                '/ƒ/' => 'f',
                '/ĝ|ğ|ġ|ģ|ґ/' => 'g',
                '/ĥ|ħ/' => 'h',
                '/ì|í|î|ï|ĩ|ī|ĭ|ǐ|į|ı|і/' => 'i',
                '/ĳ/' => 'ij',
                '/ĵ/' => 'j',
                '/ķ/' => 'k',
                '/ĺ|ļ|ľ|ŀ|ł/' => 'l',
                '/ñ|ń|ņ|ň|ŉ/' => 'n',
                '/ò|ó|ô|õ|ō|ŏ|ǒ|ő|ơ|ø|ǿ|º/' => 'o',
                '/ö|œ/' => 'oe',
                '/ŕ|ŗ|ř/' => 'r',
                '/ś|ŝ|ş|ș|š|ſ/' => 's',
                '/ß/' => 'ss',
                '/ţ|ț|ť|ŧ/' => 't',
                '/þ/' => 'th',
                '/ù|ú|û|ũ|ū|ŭ|ů|ű|ų|ư|ǔ|ǖ|ǘ|ǚ|ǜ/' => 'u',
                '/ü/' => 'ue',
                '/ŵ/' => 'w',
                '/ý|ÿ|ŷ/' => 'y',
                '/є/' => 'ye',
                '/ї/' => 'yi',
                '/ź|ż|ž/' => 'z',
            ];
            $quotedReplacement = preg_quote($replacement, '/');

            $merge = array(
                '/[^\s\p{Zs}\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}]/mu' => ' ',
                '/[\s\p{Zs}]+/mu' => $replacement,
                sprintf('/^[%s]+|[%s]+$/', $quotedReplacement, $quotedReplacement) => '',
            );

            $map = $transliteration + $merge;
            return strtolower(preg_replace(array_keys($map), array_values($map), $string));
        }
        

        public static function array_map_recursive($callback, $array) {
            foreach ($array as $key => $value) {
                if (is_array($array[$key])) {
                    $array[$key] = Utilities::array_map_recursive($callback, $array[$key]);
                }
                else {
                    $array[$key] = call_user_func($callback, $array[$key]);
                }
            }
            return $array;
        }
    }
