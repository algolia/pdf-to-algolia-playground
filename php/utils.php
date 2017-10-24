<?php

function chunkText($text, $chunkSize)
{
    while (true) {
        $text = trim($text);
        if (mb_strlen($text) <= $chunkSize) {
            $values[] = $text;
            return $values;
        }
        $cutAtPosition = mb_strpos($text, ' ', $chunkSize);
        if (false === $cutAtPosition) {
            $cutAtPosition = $chunkSize;
        }
        $values[] = mb_strcut($text, 0, $cutAtPosition);
        $text = mb_strcut($text, $cutAtPosition);
    }
}