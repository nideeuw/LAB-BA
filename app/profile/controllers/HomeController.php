<?php
/**
 * Controller: HomeController
 * Location: app/profile/controllers/HomeController.php
 * Purpose: Home page with ALL dynamic content (including former About Lab content)
 * Architecture: Controller -> Model -> View (CORRECT WAY)
 */

class HomeController extends Controller
{
    public function index($conn, $params = [])
    {
        // Get base URL
        $base_url = getBaseUrl();

        // GET ALL DATA FROM MODELS (Controller layer)
        // 1. Get active About Us data
        $aboutUs = ProfileLabModel::getActiveProfileLab($conn);
        
        // 2. Get active banner items
        $bannerItems = BannerModel::getActiveBanner($conn);
        
        // 3. Get active contact info for footer
        $contactInfo = ContactModel::getActiveContact($conn);
        
        // 4. Get Visi Misi data
        $visiMisi = VisiMisiModel::getActiveVisiMisi($conn);
        
        // 5. Get Roadmap items
        $roadmapItems = RoadmapModel::getActiveRoadmap($conn);
        
        // 6. Get Research Focus data
        $researchFocus = ResearchFocusModel::getActiveResearchFocus($conn);
        
        // 7. Get Research Scope data
        $researchScope = ResearchScopeModel::getActiveResearchScope($conn);

        // Prepare data for view
        $data = [
            'page_title' => 'Home - LAB-BA',
            'base_url' => $base_url,
            'aboutUs' => $aboutUs,
            'bannerItems' => $bannerItems,
            'contactInfo' => $contactInfo,
            'visiMisi' => $visiMisi,
            'roadmapItems' => $roadmapItems,
            'researchFocus' => $researchFocus,
            'researchScope' => $researchScope,
            'conn' => $conn
        ];

        // Load view with data
        $this->view('profile/views/home', $data);
    }
}