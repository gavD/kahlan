<?php
namespace kahlan\reporter\coverage\exporter;

class Coveralls
{
    /**
     * Write a coverage to an ouput file.
     *
     * @param  array   $options The option where the possible values are:
     *                 -`'collector'` The collector instance.
     *                 -`'file'` The output file name.
     * @return boolean
     */
    public static function write($options)
    {
        $defaults = [
            'collector' => null,
            'file' => null
        ];
        $options += $defaults;

        if (!$file = $options['file']) {
            throw new RuntimeException("Missing file name");
        }
        unset($options['file']);
        return file_put_contents($file, static::export($options));
    }

    /**
     * Export a coverage to a string.
     *
     * @param  array   $options The option array where the possible values are:
     *                 -`'collector'` The collector instance.
     *                 -`'service_name'` The name of the service.
     *                 -`'service_job_id'` The job id of the service.
     *                 -`'repo_token'` The Coveralls repo token
     *                 -`'run_at'` The date of a timestamp.
     * @return boolean
     */
    public static function export($options)
    {
        $defaults = [
            'collector' => null,
            'service_name' => '',
            'service_job_id' => null,
            'repo_token' => null,
            'run_at' => date('Y-m-d H:i:s O')
        ];
        $options += $defaults;

        $collector = $options['collector'];

        $result = $options;
        unset($result['collector']);

        foreach ($collector->export() as $file => $data) {
            $nbLines = substr_count(file_get_contents($file), "\n");

            $lines = [];
            for ($i = 0; $i <= $nbLines; $i++) {
                $lines[] = isset($data[$i]) ? $data[$i] : null;
            }

            $result['source_files'][] = [
                'name' => $file,
                'source' => file_get_contents($file),
                'coverage' => $lines
            ];
        }

        return json_encode($result);
    }
}
