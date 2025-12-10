<?php

class TentangLabController extends Controller
{
    public function index($conn, $params = [])
    {
        $base_url = getBaseUrl();

        // Get all data from models
        $visiMisi = VisiMisiModel::getActiveVisiMisi($conn);
        $roadmapItems = RoadmapModel::getActiveRoadmap($conn);
        $researchFocus = ResearchFocusModel::getActiveResearchFocus($conn);
        $researchScope = ResearchScopeModel::getActiveResearchScope($conn);

        $data = [
            'page_title' => 'Tentang Lab - LAB-BA',
            'base_url' => $base_url,
            'visiMisi' => $visiMisi,
            'roadmapItems' => $roadmapItems,
            'researchFocus' => $researchFocus,
            'researchScope' => $researchScope,
            'conn' => $conn
        ];

        $this->view('profile/views/tentang_lab', $data);
    }
}