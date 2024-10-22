<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Officer;
use App\Models\State;
use App\Models\User;
use App\Notifications\NewComplaintSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    public function create()
    {
        $states = State::with('cities')->get();
        return view('complaints.create', compact('states'));
    }

    public function index()
    {
        $complaints = auth()->user()->complaints()->get();
        return view('complaints.index', compact('complaints'));
    }

    public function store(Request $request)
    {
        $userId = null;

        $validatedData = $request->validate([
            'description' => 'required|string',
            'incident_date' => 'required|date',
            'complaint_type' => 'nullable|string|max:255',
            'custom_type' => 'nullable|string|max:255',
            'officer_name' => 'nullable|string|max:255',
            'officer_phone_number' => 'nullable|string|max:255',
            'officer_address' => 'nullable|string|max:255',
            'officer_email' => 'nullable|email|max:255',
            'officer_race' => 'nullable|string|max:255',
            'officer_eye_color' => 'nullable|string|max:255',
            'officer_weight' => 'nullable|string|max:255',
            'officer_height' => 'nullable|string|max:255',
            'officer_nickname' => 'nullable|string|max:255',
            'officer_date_of_birth' => 'nullable|date',
            'officer_work_location' => 'nullable|string|max:255',
            'officer_gender' => 'nullable|string|max:255',
            'officer_age' => 'nullable|integer',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,gif,mp4,pdf,doc,docx|max:10240',
            'state' => 'required|exists:states,id',
            'city' => 'required|exists:cities,id',
            'witnesses' => 'nullable|array',
            'witnesses.*.name' => 'required|string|max:255',
            'witnesses.*.contact' => 'required|string|max:15',
            'witnesses.*.email' => 'required|email|max:255',
        ]);

        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            $validatedData = array_merge($validatedData, $request->validate([
                'anonymous' => 'required|boolean',
                'first_name' => 'required_if:anonymous,1|nullable|string|max:255',
                'last_name' => 'required_if:anonymous,1|nullable|string|max:255',
                'phone' => 'required_if:anonymous,1|nullable|string|max:15',
                'email' => 'required_if:anonymous,1|nullable|email|unique:users,email',
                'password' => 'required_if:anonymous,1|nullable|string|min:8',
                'address' => 'required_if:anonymous,1|nullable|string|max:255',
                'person_city' => 'required_if:anonymous,1|nullable|string|max:255',
                'person_state' => 'required_if:anonymous,1|nullable|string|max:255',
                'zip' => 'required_if:anonymous,1|nullable|string|max:10',
            ]));

            if ($validatedData['anonymous'] == '1') {
                $user = User::create([
                    'name' => $validatedData['first_name'] . ' ' . $validatedData['last_name'],
                    'email' => $validatedData['email'],
                    'password' => Hash::make($validatedData['password']),
                    'phone' => $validatedData['phone'],
                    'address' => $validatedData['address'],
                    'city' => $validatedData['person_city'],
                    'state' => $validatedData['person_state'],
                    'zip' => $validatedData['zip'],
                ]);

                Auth::login($user);
                $userId = $user->id;
            }
        }

        $complaint = Complaint::create([
            'user_id' => $userId,
            'complaint_number' => 'C-' . Str::random(8),
            'description' => $validatedData['description'],
            'incident_date' => $validatedData['incident_date'],
            'complaint_type' => $validatedData['complaint_type'],
            'status' => 'pending',
            'city_id' => $validatedData['city'],
        ]);

        Officer::create([
            'complaint_id' => $complaint->id,
            'name' => $validatedData['officer_name'],
            'phone_number' => $validatedData['officer_phone_number'],
            'address' => $validatedData['officer_address'],
            'email' => $validatedData['officer_email'],
            'race' => $validatedData['officer_race'],
            'eye_color' => $validatedData['officer_eye_color'],
            'weight' => $validatedData['officer_weight'],
            'height' => $validatedData['officer_height'],
            'nickname' => $validatedData['officer_nickname'],
            'date_of_birth' => $validatedData['officer_date_of_birth'],
            'work_location' => $validatedData['officer_work_location'],
            'gender' => $validatedData['officer_gender'],
            'age' => $validatedData['officer_age'],
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $attachment) {
                $path = $attachment->store('public');
                $complaint->attachments()->create([
                    'file_path' => $path,
                    'file_name' => $complaint->id . '-' . $attachment->getClientOriginalName(),
                ]);
            }
        }

        if (isset($validatedData['witnesses'])) {
            foreach ($validatedData['witnesses'] as $witness) {
                $complaint->witnesses()->create($witness);
            }
        }

        $this->notify($complaint);

        return redirect()->route('complaints.thank-you', ['complaint' => $complaint]);
    }

    public function show(Complaint $complaint)
    {
        $complaint->load(['attachments', 'officer', 'witnesses', 'notes']);
        return view('complaints.show', compact('complaint'));
    }

    public function thankYou(Complaint $complaint)
    {
        return view('complaints.thank-you', ['complaint' => $complaint]);
    }

    public function searchForm()
    {
        return view('complaints.search');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $results = Complaint::where(function ($q) use ($query) {
            $q->where('complaint_number', 'LIKE', "%$query%");
        })
            ->where('status', 'completed')
            ->get();

        return view('complaints.results', [
            'results' => $results,
            'query' => $query
        ]);
    }

    private function notify(Complaint $complaint): void
    {
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewComplaintSubmitted($complaint));
        }
    }
}
