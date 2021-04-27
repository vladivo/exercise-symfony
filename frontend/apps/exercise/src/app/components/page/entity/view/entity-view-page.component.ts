import {Component, OnDestroy, OnInit, ViewChild} from '@angular/core';
import {ActivatedRoute} from "@angular/router";
import {Subscription} from "rxjs";
import {EntityHostDirective} from "../../../../directives/entity-host.directive";
import {EntityViewMode} from "../../../../model/entity-component/entity-view-mode";
import {EntityClientService} from "../../../../services/entity/entity-client.service";
import {EntityComponentFactory} from "../../../../services/entity/entity-component-factory";
import {Entity} from "../../../../model/entity/entity";
import {EntityViewConfigResolverService} from "../../../../services/entity/entity-view-config-resolver.service";
import {EntityViewConfig} from "../../../../model/entity-component/entity-view-config";

@Component({
  selector: 'app-entity-view-page',
  templateUrl: './entity-view-page.component.html',
})
export class EntityViewPageComponent implements OnInit, OnDestroy {
  @ViewChild(EntityHostDirective, { static: true }) private entityHost!: EntityHostDirective;

  private paramSubscription!: Subscription;

  public entityViewMode: typeof EntityViewMode = EntityViewMode;
  public config!: EntityViewConfig;


  constructor(
    private readonly activatedRoute: ActivatedRoute,
    private readonly entityClientService: EntityClientService,
    private readonly entityComponentFactory: EntityComponentFactory,
    private readonly viewConfigResolver: EntityViewConfigResolverService,
  ) { }

  public ngOnInit(): void {
    this.paramSubscription = this.activatedRoute.params.subscribe(this.refresh.bind(this))
  }

  public ngOnDestroy(): void {
    this.paramSubscription.unsubscribe();
  }

  private refresh(): void {
    this.config = this.viewConfigResolver.resolveViewConfig(this.activatedRoute.snapshot);
    this.entityHost.viewContainerRef.clear();

    if (this.config.mode === EntityViewMode.list) {
      return this.loadMultiple()
    }

    if (this.config.id !== undefined) {
      return this.loadSingle();
    }

    return this.createSingle();
  }

  private loadSingle(): void {
    this.entityClientService.load(this.config.type, this.config.id!).toPromise().then((entity: Entity): void => {
      this.entityComponentFactory.fromSingle(entity, this.config.mode, this.entityHost.viewContainerRef);
    });
  }

  private loadMultiple(): void {
    this.entityClientService.find(this.config.type).toPromise().then((entities: Entity[]): void => {
      this.entityComponentFactory.fromMultiple(entities, this.config.mode, this.entityHost.viewContainerRef);
    });
  }

  private createSingle(): void {
    this.entityComponentFactory.fromType(this.config.type, this.config.mode, this.entityHost.viewContainerRef);
  }
}
