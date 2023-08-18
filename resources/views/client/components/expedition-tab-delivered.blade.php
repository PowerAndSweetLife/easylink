<div class="table-responsive table-sticky">

  <table class="table table-striped table-text-left">
    <thead>
      <tr>
        <th scope="col">{{ __('Shiporder') }}</th>
        <th scope="col">{{ __('Package number') }}</th>
        <th scope="col">{{ __('Category') }}</th>
        <th scope="col">{{ __('Description') }}</th>
        <th scope="col">{{ __('Courrier company') }}</th>
        <th scope="col" class="text-center">{{ __('Number of package') }}</th>
        <th scope="col" class="text-center">{{ __('Volume') }}</th>
        <th scope="col" class="text-center">{{ __('Poids') }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($lists as $colis)
        <tr>
          <td>{{ $colis->shiporder }}</td>
          <td>{{ $colis->receip_number }}</td>
          <td>{{ $colis->category->name }}</td>
          <td>{{ $colis->description }}</td>
          <td>{{ $colis->courrier_company }}</td>
          <td class="text-center">{{ $colis->number() }}</td>
          <td class="text-center">{{ $colis->volume() }} m³</td>
          <td class="text-center">{{ $colis->weight() }} kg</td>
        </tr>
      @endforeach
    </tbody>
  </table>

</div>