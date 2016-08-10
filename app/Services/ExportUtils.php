<?php

namespace App\Services;

trait ExportUtils
{
    public function export($exportType, $repositories, $route)
    {
        $records = $this->config->model->all();
        $this->config->name = $repositories->exportConfig->name;
        $this->config->creator = $repositories->exportConfig->creator;
        $this->config->company = $repositories->exportConfig->company;
        $this->config->sheetName = $repositories->exportConfig->name;
        $this->config->datafields = $repositories->exportConfig->fields;
        isset($exportType) ? $this->config->exportType = $exportType : null;
        $excel = new ExportServices($this->config, $records);
        $excel->buildExport();
        return redirect()->route($route);
    }

    public function buildCSV($repositories, $route)
    {
        $this->export('csv', $repositories, $route);
    }

    public function buildExcel($repositories, $route)
    {
        $this->export('xls', $repositories, $route);
    }
}
