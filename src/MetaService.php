<?php

namespace EdgarMendozaTech\Meta;

use EdgarMendozaTech\MediaResource\MediaResourceServiceDefaultImpl;

class MetaService
{
    private $mediaResourceService;

    public function __construct()
    {
        $this->mediaResourceService = new MediaResourceServiceDefaultImpl();
    }

    public function store(array $data): Meta
    {
        return $this->setData(new Meta(), $data);
    }

    public function update(Meta $meta, array $data): Meta
    {
        return $this->setData($meta, $data);
    }

    public function destroy(Meta $meta): void
    {
        $meta->delete();
    }

    private function setData(Meta $meta, array $data): Meta
    {
        $meta->title = $data['meta_title'];
        $meta->description = $data['meta_description'];
        $meta->index = $this->shouldIndex($data);

        $meta = $this->setMediaResource($meta, $data);

        $meta->save();

        return $meta;
    }

    private function shouldIndex(array $data): bool
    {
        return isset($data['index']) ? $data['index'] : true;
    }

    private function setMediaResource(Meta $meta, $data): Meta
    {
        if (
            isset($data['meta_media_resource_id']) &&
            $data['meta_media_resource_id'] !== null
        ) {
            if($meta->media_resource_id !== $data['meta_media_resource_id']) {
                $meta->mediaResource()->associate($data['meta_media_resource_id']);
            }
        }
        else {
            if($meta->media_resource_id !== null) {
                $meta->mediaResource()->dissociate();
            }
        }

        return $meta;
    }
}
