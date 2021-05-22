<div class="col-md-12">
  <table class="table">
    <tr>
      <td><strong> Name </strong></td>
      <td> {{ $user->formatted_full_name }}</td>
    </tr>
    <tr>
      <td><strong> Email </strong></td>
      <td>{{ $user->email }}</td>
    </tr>
    <tr>
      <td><strong> Username </strong></td>
      <td>{{ $user->username ?? "N/A" }}</td>
    </tr>
    <tr>
      <td><strong>Status</strong></td>
      <td>{{ $user->status }}</td>
    </tr>
  </table>
</div>
